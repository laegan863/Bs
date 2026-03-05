<?php

namespace App\Http\Controllers;

use App\Models\AgodaBooking;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
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

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'upcoming');

        $upcomingBookings = Booking::where('user_id', Auth::id())
            ->with('agodaBooking')
            ->where('check_out', '>=', now()->toDateString())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('check_in', 'asc')
            ->get();

        $previousBookings = Booking::where('user_id', Auth::id())
            ->with('agodaBooking')
            ->where(function ($q) {
                $q->where('check_out', '<', now()->toDateString())
                  ->orWhereIn('status', ['cancelled', 'completed']);
            })
            ->orderBy('check_out', 'desc')
            ->get();

        return view('bookings', [
            'tab' => $tab,
            'upcomingBookings' => $upcomingBookings,
            'previousBookings' => $previousBookings,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'searched_id' => 'required|string',
            'property_id' => 'required|string',
            'property_name' => 'required|string',
            'property_image' => 'nullable|string',
            'room_id' => 'required|string',
            'block_id' => 'required|string',
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
            'rate_exclusive' => 'required|numeric|min:0',
            'rate_tax' => 'required|numeric|min:0',
            'rate_fees' => 'required|numeric|min:0',
            'rate_currency' => 'required|string',
            'rate_method' => 'required|string',
            'payment_model' => 'required|string',
        ]);

        session(['booking_data' => $validated]);

        return redirect()->route('booking.checkout');
    }

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

        $agodaPayload = [
            'waitTime' => 120,
            'bookingDetails' => [
                'userCountry' => 'US',
                'searchId' => (int) $bookingData['searched_id'],
                'tag' => 'test-tag',
                'allowDuplication' => true,
                'checkIn' => $bookingData['check_in'],
                'checkOut' => $bookingData['check_out'],
                'property' => [
                    'propertyId' => (int) $bookingData['property_id'],
                    'rooms' => [
                        [
                            'blockId' => $bookingData['block_id'],
                            'rate' => [
                                'currency' => $bookingData['rate_currency'],
                                'exclusive' => (float) $bookingData['rate_exclusive'],
                                'inclusive' => (float) $bookingData['price_per_night'],
                                'tax' => (float) $bookingData['rate_tax'],
                                'fees' => (float) $bookingData['rate_fees'],
                                'method' => $bookingData['rate_method'],
                            ],
                            'surcharges' => [],
                            'guestDetails' => [
                                [
                                    'title' => 'Mr.',
                                    'firstName' => $validated['guest_first_name'],
                                    'lastName' => $validated['guest_last_name'],
                                    'countryOfResidence' => 'US',
                                    'gender' => 'Male',
                                    'age' => 30,
                                    'primary' => true,
                                ],
                            ],
                            'currency' => $bookingData['rate_currency'],
                            'paymentModel' => $bookingData['payment_model'],
                            'count' => (int) $bookingData['rooms'],
                            'adults' => (int) $bookingData['adults'],
                            'children' => (int) ($bookingData['children'] ?? 0),
                            'specialRequest' => !empty($validated['special_requests']) ? $validated['special_requests'] : 'None',
                        ],
                    ],
                ],
            ],
            'customerDetail' => [
                'language' => 'en-us',
                'title' => 'Mr.',
                'firstName' => $validated['guest_first_name'],
                'lastName' => $validated['guest_last_name'],
                'email' => $validated['guest_email'],
                'phone' => [
                    'countryCode' => '1',
                    'areaCode' => '',
                    'number' => $validated['guest_phone'] ?? '09762016124',
                ],
                'newsletter' => false,
            ],
            'paymentDetails' => [
                'creditCardInfo' => [
                    'cardType' => 'Visa',
                    'number' => '4111111111111111',
                    'expiryDate' => '032029',
                    'cvc' => '543',
                    'holderName' => strtoupper($validated['guest_first_name'] . ' ' . $validated['guest_last_name']),
                    'countryOfIssue' => 'US',
                    'issuingBank' => 'BankName',
                ],
            ],
        ];

        $agodaBookingId = null;
        $agodaResult = null;

        try {
            $agodaResponse = Http::withoutVerifying()
                ->timeout(120)
                ->withHeaders([
                    'Authorization' => '1952979:97af8aba-5b21-4a37-ad75-a034c9e46742',
                    'Content-Type' => 'application/json',
                ])->post('https://sandbox-affiliateapisecure.agoda.com/api/v4/book', $agodaPayload);

            $agodaResult = $agodaResponse->json();
            $agodaBookingId = $agodaResult['bookingDetails']['bookingId'] ?? null;

            Log::info('Agoda Book API response', [
                'status' => $agodaResponse->status(),
                'response' => $agodaResult,
            ]);
        } catch (\Exception $e) {
            Log::error('Agoda Book API call failed: ' . $e->getMessage());
        }

        $reference = Booking::generateReference();

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'agoda_booking_id' => $agodaBookingId,
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
            'tax_amount' => $bookingData['rate_tax'] ?? 0,
            'fees_amount' => $bookingData['rate_fees'] ?? 0,
            'currency' => $bookingData['rate_currency'] ?? 'USD',
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

        // return response()->json([
        //     'booking' => $booking,
        //     'agoda_result' => $agodaResult,
        // ]);

        if ($agodaResult && ($agodaResult['status'] ?? '') === '200') {
            $agodaDetails = $agodaResult['bookingDetails'][0] ?? null;
            if ($agodaDetails) {
                AgodaBooking::create([
                    'booking_id' => $booking->id,
                    'agoda_booking_id' => $agodaDetails['id'],
                    'itinerary_id' => $agodaDetails['itineraryID'],
                    'self_service_url' => $agodaDetails['selfService'],
                    'status' => $agodaResult['status'],
                    'raw_response' => $agodaResult,
                ]);
            }
        }

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

        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);
        session()->forget('booking_data');
        return redirect()->route('booking.confirmation', $booking->id);
    }

    private function processBitPayPayment(Booking $booking)
    {
        try {
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

            $booking->update([
                'bitpay_invoice_id' => 'test_fallback_' . uniqid(),
                'payment_status' => 'paid',
                'status' => 'confirmed',
            ]);

            session()->forget('booking_data');
            return redirect()->route('booking.confirmation', $booking->id);
        }
    }

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

    public function fetchAgodaDetail(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $agodaBooking = $booking->agodaBooking;

        if (!$agodaBooking) {
            return response()->json([
                'error' => 'No Agoda booking linked.',
                'booking' => $booking->toArray(),
            ], 404);
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(120)
                ->withHeaders([
                    'Authorization' => '1952979:97af8aba-5b21-4a37-ad75-a034c9e46742',
                    'Content-Type' => 'application/json',
                ])->post('https://sandbox-affiliateapisecure.agoda.com/api/v4/bookingreport/bookingdetail', [
                    'bookingIds' => [(int) $agodaBooking->agoda_booking_id],
                ]);

            $result = $response->json();

            return response()->json([
                'booking' => $booking->toArray(),
                'agoda' => $result['bookings'][0] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error('Agoda detail fetch failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to fetch from Agoda API.',
                'booking' => $booking->toArray(),
            ], 500);
        }
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $agodaBooking = $booking->agodaBooking;

        if (!$agodaBooking) {
            return back()->with('error', 'No Agoda booking linked to cancel.');
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(120)
                ->withHeaders([
                    'Authorization' => '1952979:97af8aba-5b21-4a37-ad75-a034c9e46742',
                    'Content-Type' => 'application/json',
                ])->post('https://sandbox-affiliateapisecure.agoda.com/api/v4/postBooking/cancel', [
                    'bookingId' => (int) $agodaBooking->agoda_booking_id,
                ]);

            $result = $response->json();

            Log::info('Agoda cancel response', ['booking_id' => $booking->id, 'response' => $result]);

            if ($response->successful()) {
                $booking->update([
                    'status' => 'cancelled',
                ]);
                $agodaBooking->update([
                    'status' => 'Cancelled',
                ]);

                return back()->with('success', 'Booking #' . $agodaBooking->agoda_booking_id . ' has been cancelled successfully.');
            }

            $errorMsg = $result['message'] ?? $result['error'] ?? 'Unknown error from Agoda.';
            return back()->with('error', 'Agoda cancellation failed: ' . $errorMsg);

        } catch (\Exception $e) {
            Log::error('Agoda cancel failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to cancel booking. Please try again later.');
        }
    }
    public function confirmation(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('booking-confirmation', [
            'booking' => $booking,
        ]);
    }
}
