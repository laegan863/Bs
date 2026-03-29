<?php

namespace App\Http\Controllers;

use App\Models\AgodaBooking;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

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
            ->where('payment_status', 'paid')
            ->orderBy('check_in', 'asc')
            ->get();

        $previousBookings = Booking::where('user_id', Auth::id())
            ->with('agodaBooking')
            ->where(function ($q) {
                $q->where('check_out', '<', now()->toDateString())
                  ->orWhere('payment_status','paid');
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
            'surcharge_amount' => 'nullable|numeric|min:0',
            'rate_currency' => 'required|string',
            'rate_method' => 'required|string',
            'payment_model' => 'required|string',
        ]);

        // return response()->json([
        //     'data' => $request->all()
        // ]);

        $validated['surcharge_amount'] = $validated['surcharge_amount'] ?? 0;
        session(['booking_data' => $validated]);

        return redirect()->route('booking.checkout');
    }

    public function boomfiApi($method = null, $url = null, $payload = [])
    {
        $client = new Client();
        $response = $client->request($method, $url ?? 'https://mapi.boomfi.xyz/v1/paylinks', [
            'body' => json_encode($payload),
            'headers' => [
                'X-API-KEY' => 'mailan-H1FX1saaEpBPGMqzAzbXU',
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function processBookingPayment($request, $bookingId)
    {

        $session = session('booking_data');

        if(!$session) {
            return response()->json(['error' => 'No booking data in session. Please start the booking process again.'], 400);
        }

        $client = new Client();
        $payload = [
            'name' => 'Solana Travels Payment -' . ($session['property_name'] ?? 'Unknown Property') . ' - ' . \Carbon\Carbon::now()->toDateTimeString(),
            'amount' => $session['total_price'],
            'currency' => $session['rate_currency'] ?? 'USD',
            'reference' => 'booking_' . uniqid(),
            'description' => 'Payment for hotel booking - ' . ($session['property_name'] ?? 'Unknown Property') . ' - ' . ($session['room_name'] ?? 'Unknown Room'),
        ];
        $createdPaylink = $this->boomfiApi('POST', null, $payload);
        $enablePaylink = $this->boomfiApi('PATCH', 'https://mapi.boomfi.xyz/v1/paylinks/'.$createdPaylink['data']['id'] , ['enabled' => true]);
        $createVariantPaylink = $this->boomfiApi('GET', 'https://mapi.boomfi.xyz/v1/paylinks/generate-variant/'. $createdPaylink['data']['id'] , ['redirect_to' => url('/booking/receipt/' . $bookingId)]);

        $paymentUrl = $createVariantPaylink['data']['url'];

        $paymentUrl = preg_replace('#(https://pay\.boomfi\.xyz)/(.*?)(\?.*)#', '$1/lite/$2', $paymentUrl);
        $user = auth()->user();
        if ($user) {
            $paymentUrl .= '?name=' . urlencode($user->first_name . ' ' . $user->last_name) . '&email=' . urlencode($user->email);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['url' => $paymentUrl]);
        }

        return redirect()->away($paymentUrl);
    }

    public function processPayment(Request $request)
    {
        $bookingData = session('booking_data');

        $reference = Booking::generateReference();

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'agoda_booking_id' => null,
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
            'guest_first_name' => $request->input('guest_first_name'),
            'guest_last_name' => $request->input('guest_last_name'),
            'guest_email' => $request->input('guest_email'),
            'guest_phone' => $request->input('guest_phone'),
            'special_requests' => $request->input('special_requests') ?? null,
            'payment_method' => $request->input('payment_method'),
            'payment_status' => 'pending',
            'transaction_reference' => $reference,
            'status' => 'pending',
            'free_cancellation' => $bookingData['free_cancellation'] ?? false,
            'cancellation_deadline' => $bookingData['cancellation_deadline'] ?? null,
        ]);

        return $this->processBookingPayment($request, $booking->id);
    }

    public function confirmBooking($id)
    {
        $bookingData = \App\Models\Booking::findOrFail($id);

        if ($bookingData->user_id !== Auth::id()) {
            abort(403);
        }

        $sessionData = session('booking_data');

        if (!$sessionData) {
            return redirect()->route('landing')->with('error', 'Session expired. Please start the booking process again.');
        }

        $agodaPayload = [
            'waitTime' => 120,
            'bookingDetails' => [
                'userCountry' => 'US',
                'searchId' => (int) $sessionData['searched_id'],
                'tag' => 'test-tag',
                'allowDuplication' => true,
                'checkIn' => $bookingData['check_in'],
                'checkOut' => $bookingData['check_out'],
                'property' => [
                    'propertyId' => (int) $bookingData['property_id'],
                    'rooms' => [
                        [
                            'blockId' => $sessionData['block_id'],
                            'rate' => [
                                'currency' => $sessionData['rate_currency'],
                                'exclusive' => (float) $sessionData['rate_exclusive'],
                                'inclusive' => (float) $bookingData['price_per_night'],
                                'tax' => (float) $sessionData['rate_tax'],
                                'fees' => (float) $sessionData['rate_fees'],
                                'method' => $sessionData['rate_method'],
                            ],
                            'surcharges' => [],
                            'guestDetails' => [
                                [
                                    'title' => 'Mr.',
                                    'firstName' => $bookingData['guest_first_name'],
                                    'lastName' => $bookingData['guest_last_name'],
                                    'countryOfResidence' => 'US',
                                    'gender' => 'Male',
                                    'age' => 30,
                                    'primary' => true,
                                ],
                            ],
                            'currency' => $sessionData['rate_currency'],
                            'paymentModel' => $sessionData['payment_model'],
                            'count' => (int) $bookingData['rooms'],
                            'adults' => (int) $bookingData['adults'],
                            'children' => (int) ($bookingData['children'] ?? 0),
                            'specialRequest' => !empty($bookingData['special_requests']) ? $bookingData['special_requests'] : 'None',
                        ],
                    ],
                ],
            ],
            'customerDetail' => [
                'language' => 'en-us',
                'title' => 'Mr.',
                'firstName' => $bookingData['guest_first_name'],
                'lastName' => $bookingData['guest_last_name'],
                'email' => $bookingData['guest_email'],
                'phone' => [
                    'countryCode' => '1',
                    'areaCode' => '',
                    'number' => $bookingData['guest_phone'] ?? '09762016124',
                ],
                'newsletter' => false,
            ],
            'paymentDetails' => [
                'creditCardInfo' => [
                    'cardType' => 'Visa',
                    'number' => '4111111111111111',
                    'expiryDate' => '032029',
                    'cvc' => '543',
                    'holderName' => strtoupper($bookingData['guest_first_name'] . ' ' . $bookingData['guest_last_name']),
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

        if ($agodaResult && ($agodaResult['status'] ?? '') === '200') {
            $agodaDetails = $agodaResult['bookingDetails'][0] ?? null;
            if ($agodaDetails) {
                AgodaBooking::create([
                    'booking_id' => $bookingData->id,
                    'agoda_booking_id' => $agodaDetails['id'],
                    'itinerary_id' => $agodaDetails['itineraryID'],
                    'self_service_url' => $agodaDetails['selfService'],
                    'status' => $agodaResult['status'],
                    'raw_response' => $agodaResult,
                ]);
            }
        }

        $bookingData->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);
        session()->forget('booking_data');
        return redirect()->route('booking.confirmation', $bookingData->id);
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
                ])->post('https://sandbox-affiliateapisecure.agoda.com/api/v4/postbooking/confirmcancel', [
                    'bookingId'  => (int) $agodaBooking->agoda_booking_id,
                    'reference'  => (int) $agodaBooking->itinerary_id,
                    'cancelReason' => 0,
                    'refundRate' => [
                        'currency'  => $booking->currency,
                        'inclusive' => 0.0,
                    ],
                ]);

            $result = $response->json();

            Log::info('Agoda cancel response', ['booking_id' => $booking->id, 'response' => $result]);

            // Check for Agoda-level error in the response body first
            if (!empty($result['errorMessage']['message'])) {
                $errorMsg = $result['errorMessage']['message'];
                return back()->with('error', 'Agoda cancellation failed: ' . $errorMsg);
            }

            if ($response->successful()) {
                $booking->update(['status' => 'cancelled']);
                $agodaBooking->update(['status' => 'Cancelled']);

                return back()->with('success', 'Booking #' . $agodaBooking->agoda_booking_id . ' has been cancelled successfully.');
            }

            // Fallback error from HTTP-level failure
            $errorMsg = $result['message'] ?? $result['error'] ?? 'Unknown error from Agoda.';
            return back()->with('error', 'Agoda cancellation failed: ' . $errorMsg);

        } catch (\Exception $e) {
            Log::error('Agoda cancel failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to cancel booking. Please try again later.');
        }
    }

    public function editAmendment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $agodaBooking = $booking->agodaBooking;

        if (!$agodaBooking) {
            return response()->json([
                'error' => 'No Agoda booking linked.',
            ], 404);
        }

        return response()->json([
            'booking' => $booking->toArray(),
            'agoda_booking_id' => (int) $agodaBooking->agoda_booking_id,
        ]);
    }

    public function submitAmendment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $agodaBooking = $booking->agodaBooking;

        if (!$agodaBooking) {
            return response()->json([
                'error' => 'No Agoda booking linked to amend.',
            ], 404);
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(120)
                ->withHeaders([
                    'Authorization' => '1952979:97af8aba-5b21-4a37-ad75-a034c9e46742',
                    'Content-Type' => 'application/json',
                ])->post('https://sandbox-affiliateapisecure.agoda.com/api/v4/postBooking/amendment', [
                    'bookingId' => (int) $agodaBooking->agoda_booking_id,
                    'amendmentDetails' => [
                        'amendmentType' => 1,
                        'bookingPeriod' => [
                            'checkIn' => $request->check_in,
                            'checkOut' => $request->check_out,
                        ],
                    ],
                ]);

            $result = $response->json();

            Log::info('Agoda amendment response', ['booking_id' => $booking->id, 'response' => $result]);

            if ($response->successful() && ($result['status'] ?? '') === '200') {
                $booking->update([
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    'amendments' => array_merge($booking->amendments ?? [], [[
                        'type' => 'date_change',
                        'old_check_in' => $booking->getOriginal('check_in'),
                        'old_check_out' => $booking->getOriginal('check_out'),
                        'new_check_in' => $request->check_in,
                        'new_check_out' => $request->check_out,
                        'amendment_identifier' => $result['amendmentIdentifier'] ?? null,
                        'amended_at' => now()->toIso8601String(),
                    ]]),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Booking amended successfully.',
                    'data' => $result,
                ]);
            }

            $errorMsg = $result['errorMessage']['message'] ?? $result['message'] ?? $result['error'] ?? 'Unknown error from Agoda.';
            return response()->json([
                'success' => false,
                'error' => $errorMsg,
                'data' => $result,
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Agoda amendment failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to amend booking. Please try again later.',
            ], 500);
        }
    }

    public function confirmation(Booking $booking)
    {
        // if ($booking->user_id !== Auth::id()) {
        //     abort(403);
        // }

        return view('booking-confirmation', [
            'booking' => $booking,
        ]);
    }
}
