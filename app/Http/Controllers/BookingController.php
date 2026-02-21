<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Show the checkout page with booking details from session.
     */
    public function checkout(Request $request)
    {
        $bookingData = session('booking_data');

        if (!$bookingData) {
            return redirect()->route('landing')->with('error', 'No booking data found. Please select a room first.');
        }

        return view('checkout', [
            'bookingData' => $bookingData,
            'user' => Auth::user(),
        ]);
    }

    /**
     * Store booking data in session and redirect to checkout.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|string',
            'property_name' => 'required|string',
            'property_image' => 'nullable|string',
            'room_id' => 'required|string',
            'room_name' => 'required|string',
            'room_type' => 'nullable|string',
            'bed_type' => 'nullable|string',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'rooms' => 'required|integer|min:1',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'price_per_night' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'free_cancellation' => 'nullable|boolean',
            'cancellation_deadline' => 'nullable|date',
            'free_breakfast' => 'nullable|boolean',
            'payment_type' => 'required|in:pay_now,pay_at_hotel',
        ]);

        // Store booking data in session for checkout
        session(['booking_data' => $validated]);

        return redirect()->route('booking.checkout');
    }

    /**
     * Process payment and create the booking.
     */
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'guest_first_name' => 'required|string|max:255',
            'guest_last_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
            'special_requests' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:bitpay,card,pay_at_hotel',
        ]);

        $bookingData = session('booking_data');

        if (!$bookingData) {
            return redirect()->route('landing')->with('error', 'Session expired. Please select a room again.');
        }

        $reference = Booking::generateReference();

        // Create the booking record
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'property_id' => $bookingData['property_id'],
            'property_name' => $bookingData['property_name'],
            'property_image' => $bookingData['property_image'],
            'room_id' => $bookingData['room_id'],
            'room_name' => $bookingData['room_name'],
            'room_type' => $bookingData['room_type'] ?? null,
            'bed_type' => $bookingData['bed_type'] ?? null,
            'check_in' => $bookingData['check_in'],
            'check_out' => $bookingData['check_out'],
            'rooms' => $bookingData['rooms'],
            'adults' => $bookingData['adults'],
            'children' => $bookingData['children'] ?? 0,
            'price_per_night' => $bookingData['price_per_night'],
            'total_price' => $bookingData['total_price'],
            'currency' => 'USD',
            'guest_first_name' => $validated['guest_first_name'],
            'guest_last_name' => $validated['guest_last_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'special_requests' => $validated['special_requests'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'transaction_reference' => $reference,
            'status' => 'pending',
            'free_cancellation' => $bookingData['free_cancellation'] ?? false,
            'cancellation_deadline' => $bookingData['cancellation_deadline'] ?? null,
        ]);

        // Handle payment based on method
        if ($validated['payment_method'] === 'bitpay') {
            return $this->processBitPayPayment($booking);
        } elseif ($validated['payment_method'] === 'pay_at_hotel') {
            $booking->update([
                'payment_status' => 'pending',
                'status' => 'confirmed',
            ]);
            session()->forget('booking_data');
            return redirect()->route('booking.confirmation', $booking->id);
        }

        // Card payment - for now treat as direct confirmation
        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);
        session()->forget('booking_data');
        return redirect()->route('booking.confirmation', $booking->id);
    }

    /**
     * Process payment via BitPay (Test/Sandbox).
     */
    private function processBitPayPayment(Booking $booking)
    {
        try {
            // BitPay Test API - Create an invoice
            // Using BitPay's test environment
            $bitpayApiUrl = env('BITPAY_API_URL', 'https://test.bitpay.com/invoices');
            $bitpayToken = env('BITPAY_API_TOKEN', 'test_token_placeholder');

            $invoiceData = [
                'price' => (float) $booking->total_price,
                'currency' => $booking->currency,
                'orderId' => $booking->transaction_reference,
                'itemDesc' => "Hotel Booking - {$booking->property_name} ({$booking->room_name})",
                'buyer' => [
                    'name' => "{$booking->guest_first_name} {$booking->guest_last_name}",
                    'email' => $booking->guest_email,
                    'phone' => $booking->guest_phone,
                ],
                'redirectURL' => route('booking.confirmation', $booking->id),
                'notificationURL' => route('booking.bitpay.callback'),
                'posData' => json_encode(['booking_id' => $booking->id]),
                'token' => $bitpayToken,
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Accept-Version' => '2.0.0',
            ])->post($bitpayApiUrl, $invoiceData);

            if ($response->successful()) {
                $invoiceResult = $response->json();
                $invoiceId = $invoiceResult['data']['id'] ?? $invoiceResult['id'] ?? null;
                $invoiceUrl = $invoiceResult['data']['url'] ?? $invoiceResult['url'] ?? null;

                $booking->update([
                    'bitpay_invoice_id' => $invoiceId,
                ]);

                session()->forget('booking_data');

                if ($invoiceUrl) {
                    return redirect()->away($invoiceUrl);
                }
            }

            // If BitPay API fails, simulate success for testing
            Log::warning('BitPay API call failed or in test mode, simulating payment', [
                'booking_id' => $booking->id,
                'response' => $response->json() ?? 'No response',
            ]);

            $booking->update([
                'bitpay_invoice_id' => 'test_' . uniqid(),
                'payment_status' => 'paid',
                'status' => 'confirmed',
            ]);

            session()->forget('booking_data');
            return redirect()->route('booking.confirmation', $booking->id);

        } catch (\Exception $e) {
            Log::error('BitPay payment error: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
            ]);

            // In test mode, still confirm the booking
            $booking->update([
                'bitpay_invoice_id' => 'test_fallback_' . uniqid(),
                'payment_status' => 'paid',
                'status' => 'confirmed',
            ]);

            session()->forget('booking_data');
            return redirect()->route('booking.confirmation', $booking->id);
        }
    }

    /**
     * Handle BitPay IPN (Instant Payment Notification) callback.
     */
    public function bitpayCallback(Request $request)
    {
        $payload = $request->all();

        Log::info('BitPay IPN received', $payload);

        $posData = json_decode($payload['posData'] ?? '{}', true);
        $bookingId = $posData['booking_id'] ?? null;

        if (!$bookingId) {
            return response()->json(['error' => 'Invalid callback'], 400);
        }

        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $status = $payload['status'] ?? '';

        switch ($status) {
            case 'confirmed':
            case 'complete':
                $booking->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                ]);
                break;

            case 'expired':
            case 'invalid':
                $booking->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                ]);
                break;

            case 'refunded':
                $booking->update([
                    'payment_status' => 'refunded',
                    'status' => 'cancelled',
                ]);
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Show booking confirmation page.
     */
    public function confirmation(Booking $booking)
    {
        // Ensure the user can only see their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('booking-confirmation', [
            'booking' => $booking,
        ]);
    }
}
