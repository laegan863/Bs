<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolanaTravels - Book Hotels with Crypto & Save Up to 75%</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/property.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<section class="py-4">
    <div class="container">
        <div class="checkout-page">
        <div class="my-3">
            <h3 style="color: darkblue;" class="fw-bold">Secure Booking</h3>
        </div>
        @if($bookingData['free_cancellation'] ?? false)
        <div class="rounded-4 px-3 py-2 d-flex flex-row mb-4 justify-content-start align-items-start gap-3 bg-white card">
            <div class="fs-4 text-center">🗓️</div>
            <div>
                <div class="fw-semibold text-dark">
                    Fully refundable before {{ \Carbon\Carbon::parse($bookingData['cancellation_deadline'] ?? now())->format('D, M d, g:ia') }} (property local time)
                </div>
                <div class="text-secondary">
                    You can change or cancel this stay if plans change. Because flexibility matters.
                </div>
            </div>
        </div>
        @else
        <div class="rounded-4 px-3 py-2 d-flex flex-row mb-4 justify-content-start align-items-start gap-3 bg-white card">
            <div class="fs-4 text-center">⚠️</div>
            <div>
                <div class="fw-semibold text-dark">
                    Non-refundable
                </div>
                <div class="text-secondary">
                    This booking cannot be cancelled or modified once confirmed. No refund will be issued.
                </div>
            </div>
        </div>
        @endif

            <div class="row g-4">
            
                <!-- Right: Booking Summary Sidebar -->
                <div class="col-lg-5">
                    <div class="checkout-summary-card sticky-top" style="top: 100px;">
                        <!-- Property Image -->
                        <div class="checkout-summary-image">
                            <img src="{{ $bookingData['property_image'] ?? asset('assets/images/login-1.jpg') }}" alt="{{ $bookingData['property_name'] ?? '' }}">
                            <div class="checkout-summary-image-overlay">
                                <span class="badge bg-dark bg-opacity-75 px-3 py-2">
                                    <i class="bi bi-star-fill text-warning me-1"></i> 9.2 Wonderful
                                </span>
                            </div>
                        </div>

                        <!-- Property Info -->
                        <div class="checkout-summary-body">
                            <h5 class="fw-bold mb-1">{{ $bookingData['property_name'] ?? 'Hotel' }}</h5>
                            <p class="small text-muted mb-3">{{ $bookingData['room_name'] ?? '' }}</p>

                            <div class="checkout-summary-details">
                                <div class="checkout-detail-row">
                                    <div class="checkout-detail-icon"><i class="bi bi-box-arrow-in-right"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Check-in</small>
                                        <span class="fw-medium small">{{ \Carbon\Carbon::parse($bookingData['check_in'])->format('D, M d, Y') }}</span>
                                    </div>
                                </div>
                                <div class="checkout-detail-row">
                                    <div class="checkout-detail-icon"><i class="bi bi-box-arrow-right"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Check-out</small>
                                        <span class="fw-medium small">{{ \Carbon\Carbon::parse($bookingData['check_out'])->format('D, M d, Y') }}</span>
                                    </div>
                                </div>
                                <div class="checkout-detail-row">
                                    <div class="checkout-detail-icon"><i class="bi bi-moon"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Duration</small>
                                        @php $nights = \Carbon\Carbon::parse($bookingData['check_in'])->diffInDays(\Carbon\Carbon::parse($bookingData['check_out'])); @endphp
                                        <span class="fw-medium small">{{ $nights }} night{{ $nights > 1 ? 's' : '' }}</span>
                                    </div>
                                </div>
                                <div class="checkout-detail-row">
                                    <div class="checkout-detail-icon"><i class="bi bi-people"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Guests</small>
                                        <span class="fw-medium small">{{ $bookingData['adults'] }} adult{{ $bookingData['adults'] > 1 ? 's' : '' }}, {{ $bookingData['rooms'] }} room{{ $bookingData['rooms'] > 1 ? 's' : '' }}</span>
                                    </div>
                                </div>
                                @if($bookingData['bed_type'] ?? false)
                                <div class="checkout-detail-row">
                                    <div class="checkout-detail-icon"><i class="bi bi-house-door"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Bed Type</small>
                                        <span class="fw-medium small">{{ $bookingData['bed_type'] }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Badges -->
                            <div class="d-flex flex-wrap gap-2 my-3">
                                @if($bookingData['free_breakfast'] ?? false)
                                @php $totalGuests = (int)($bookingData['adults'] ?? 0) + (int)($bookingData['children'] ?? 0); @endphp
                                <span class="badge bg-primary-subtle text-primary"><i class="bi bi-cup-hot me-1"></i>Breakfast Included for {{ $totalGuests }}</span>
                                @endif
                                @if($bookingData['free_cancellation'] ?? false)
                                <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Free Cancellation</span>
                                @endif
                            </div>

                            <hr>

                            <!-- Price Breakdown -->
                            <div class="checkout-price-breakdown">
                                @php
                                    $checkoutSurcharges = json_decode($bookingData['surcharges'] ?? '[]', true) ?: [];
                                    $checkoutIncluded   = array_filter($checkoutSurcharges, fn($s) => in_array($s['type'] ?? '', ['Included', 'Mandatory']));
                                    $checkoutExcluded   = array_filter($checkoutSurcharges, fn($s) => ($s['type'] ?? '') === 'Excluded');
                                    $checkoutRateTax    = (float)($bookingData['total_payment_tax'] ?? $bookingData['rate_tax'] ?? 0);
                                    $checkoutRateFees   = (float)($bookingData['total_payment_fees'] ?? $bookingData['rate_fees'] ?? 0);
                                    $checkoutRateExcl   = (float)($bookingData['total_payment_exclusive'] ?? $bookingData['rate_exclusive'] ?? 0);
                                    $checkoutTotalInclusive = (float)($bookingData['total_payment_inclusive'] ?? $bookingData['total_price'] ?? 0);
                                    $checkoutInclSurchargeTotal = collect($checkoutIncluded)->sum(fn($s) => (float)($s['amount'] ?? 0));
                                    $checkoutPaidOnlineTotal = $checkoutTotalInclusive + $checkoutInclSurchargeTotal;
                                @endphp

                                {{-- ── Paid Online ── --}}
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge rounded-pill" style="background:#e0f2fe; color:#0369a1; font-size:0.65rem; font-weight:600;">PAID ONLINE</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Price per night</span>
                                    <span class="small fw-medium">US${{ number_format($bookingData['price_per_night'], 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Duration</span>
                                    <span class="small fw-medium">{{ $nights }} night{{ $nights > 1 ? 's' : '' }}</span>
                                </div>
                                @if($checkoutRateExcl > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Room rate</span>
                                    <span class="small fw-medium">US${{ number_format($checkoutRateExcl, 2) }}</span>
                                </div>
                                @endif
                                @if($checkoutRateTax > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Taxes</span>
                                    <span class="small fw-medium">US${{ number_format($checkoutRateTax, 2) }}</span>
                                </div>
                                @endif
                                @if($checkoutRateFees > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Fees</span>
                                    <span class="small fw-medium">US${{ number_format($checkoutRateFees, 2) }}</span>
                                </div>
                                @endif
                                @foreach($checkoutIncluded as $cs)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">{{ $cs['name'] ?? 'Surcharge' }}</span>
                                    <span class="small fw-medium">US${{ number_format((float)($cs['amount'] ?? 0), 2) }}</span>
                                </div>
                                @endforeach
                                <hr class="my-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold">Total (paid online)</span>
                                    <span class="fw-bold checkout-total-price">US${{ number_format($checkoutPaidOnlineTotal, 2) }}</span>
                                </div>
                                <small class="text-muted d-block">Includes all taxes &amp; fees above</small>

                                {{-- ── Pay at Hotel ── --}}
                                @if(count($checkoutExcluded) > 0)
                                <div class="mt-3 p-3 rounded-3" style="background:#fff8e1; border:1px solid #fde68a; border-top:2px solid #f59e0b;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-building" style="color:#d97706;"></i>
                                            <span class="fw-bold small" style="color:#92400e;">PAY AT HOTEL</span>
                                        </div>
                                        <span class="badge rounded-pill" style="background:#fef3c7; color:#92400e; font-size:0.6rem;">Not included in total</span>
                                    </div>
                                    @foreach($checkoutExcluded as $cs)
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small" style="color:#92400e;">{{ $cs['name'] ?? 'Hotel fee' }}</span>
                                        <span class="small fw-bold" style="color:#92400e;">
                                            {{ (float)($cs['amount'] ?? 0) > 0 ? 'US$'.number_format((float)$cs['amount'], 2) : 'Varies' }}
                                        </span>
                                    </div>
                                    @endforeach
                                    <small class="d-block mt-2" style="font-size:0.68rem; color:#b45309;">Collected directly by the hotel at check-in or check-out.</small>
                                </div>
                                @endif
                            </div>

                            <!-- Payment Type Badge -->
                            <div class="checkout-payment-badge mt-3">
                                @if(($bookingData['payment_type'] ?? 'pay_now') === 'pay_at_hotel')
                                <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: #fff8e1;">
                                    <i class="bi bi-building text-warning" style="font-size: 1.2rem;"></i>
                                    <div>
                                        <span class="fw-bold small">Pay at Hotel</span>
                                        <small class="d-block text-muted">No upfront payment required</small>
                                    </div>
                                </div>
                                @else
                                <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: #e8f5e9;">
                                    <i class="bi bi-shield-check text-success" style="font-size: 1.2rem;"></i>
                                    <div>
                                        <span class="fw-bold small">Secure Payment</span>
                                        <small class="d-block text-muted">Pay now with crypto or card</small>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Left: Checkout Form -->
                <div class="col-lg-7">
                    <form action="{{ route('booking.process') }}" method="POST" id="checkoutForm">
                        @csrf
                        <!-- Step 1: Guest Details -->
                        <div class="checkout-card mb-4">
                            <div class="checkout-card-header">
                                <div class="checkout-step-badge">1</div>
                                <div>
                                    <h5 class="fw-bold mb-0">Guest Details</h5>
                                    <p class="text-muted small mb-0">Tell us who's checking in</p>
                                </div>
                            </div>
                            <div class="checkout-card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control checkout-input" name="guest_first_name"
                                               value="{{ $user->first_name ?? '' }}" required placeholder="Enter first name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control checkout-input" name="guest_last_name"
                                               value="{{ $user->last_name ?? '' }}" required placeholder="Enter last name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control checkout-input" name="guest_email"
                                               value="{{ $user->email ?? '' }}" required placeholder="email@example.com">
                                        <small class="text-muted">Confirmation will be sent to this email</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small">Phone Number</label>
                                        <input type="tel" class="form-control checkout-input" name="guest_phone"
                                               value="{{ $user->phone ?? '' }}" placeholder="+1 (555) 000-0000">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-medium small">Special Requests</label>
                                        <textarea class="form-control checkout-input" name="special_requests" rows="3"
                                                  placeholder="Any special requests? (e.g., early check-in, extra pillows, high floor)"></textarea>
                                        <small class="text-muted">Special requests are subject to availability</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Payment Method -->
                        <div class="checkout-card mb-4">
                            <div class="checkout-card-header">
                                <div class="checkout-step-badge">2</div>
                                <div>
                                    <h5 class="fw-bold mb-0">Payment Method</h5>
                                    <p class="text-muted small mb-0">Choose how you'd like to pay</p>
                                </div>
                            </div>
                            <div class="checkout-card-body">
                                @if(($bookingData['payment_type'] ?? 'pay_now') === 'pay_at_hotel')
                                <!-- Pay at Hotel Selected -->
                                <div class="checkout-payment-option selected" onclick="selectCheckoutPayment('pay_at_hotel')">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="checkout-radio active">
                                            <div class="checkout-radio-dot"></div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1"><i class="bi bi-building me-2"></i>Pay at Hotel</h6>
                                            <p class="small text-muted mb-0">No payment required now. Pay at the property when you arrive.</p>
                                        </div>
                                        <span class="badge bg-warning-subtle text-warning px-3 py-2">Selected</span>
                                    </div>
                                </div>
                                <input type="hidden" name="payment_method" value="pay_at_hotel">
                                @else
                                <!-- Pay Now Options -->
                                <div class="checkout-payment-tabs mb-3">
                                    <button type="button" class="checkout-pay-tab active" data-method="bitpay" onclick="selectCheckoutPayment('bitpay')">
                                        <i class="bi bi-currency-bitcoin"></i>
                                        <span>Crypto (BoomFi)</span>
                                    </button>
                                    @if($creditBalance > 0)
                                    <button type="button" class="checkout-pay-tab" data-method="credit" onclick="selectCheckoutPayment('credit')">
                                        <i class="bi bi-wallet2"></i>
                                        <span>Travel Credit</span>
                                    </button>
                                    @endif
                                </div>

                                <input type="hidden" name="payment_method" id="checkoutPaymentMethod" value="bitpay">

                                <!-- BitPay Section -->
                                <div class="checkout-payment-section" id="paySection_bitpay">
                                    <div class="crypto-payment-box">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                <img src="{{ asset('boomfi.png') }}" alt="" width="60" height="60" class="rounded-circle">
                                            <div>
                                                <h6 class="fw-bold mb-0">Pay with Cryptocurrency</h6>
                                                <p class="small text-muted mb-0">Bitcoin, Ethereum, and 100+ cryptos accepted via BoomFi</p>
                                            </div>
                                        </div>
                                        <div class="crypto-features">
                                            <div class="crypto-feature-item">
                                                <i class="bi bi-shield-check text-success"></i>
                                                <span class="small">Secure & encrypted payment</span>
                                            </div>
                                            <div class="crypto-feature-item">
                                                <i class="bi bi-lightning text-warning"></i>
                                                <span class="small">Instant confirmation</span>
                                            </div>
                                            <div class="crypto-feature-item">
                                                <i class="bi bi-globe text-info"></i>
                                                <span class="small">No currency conversion fees</span>
                                            </div>
                                        </div>
                                        <div class="crypto-logos-strip mt-3">
                                            <span class="crypto-logo-pill"><i class="bi bi-currency-bitcoin"></i> BTC</span>
                                            <span class="crypto-logo-pill"><i class="bi bi-currency-exchange"></i> ETH</span>
                                            <span class="crypto-logo-pill"><i class="bi bi-coin"></i> USDT</span>
                                            <span class="crypto-logo-pill"><i class="bi bi-coin"></i> USDC</span>
                                            <span class="crypto-logo-pill text-muted">+100 more</span>
                                        </div>
                                        <p class="small text-muted mt-3 mb-0">
                                            <i class="bi bi-info-circle me-1"></i>
                                            You'll be redirected to BitPay to complete your payment securely.
                                        </p>
                                    </div>
                                </div>

                                <!-- Credit Section -->
                                @if($creditBalance > 0)
                                <div class="checkout-payment-section d-none" id="paySection_credit">
                                    <div class="p-4 rounded-3 border" style="background: linear-gradient(135deg, #f1f8e9, #e8f5e9); border-color: #a5d6a7 !important;">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width:48px; height:48px; background: linear-gradient(135deg,#66bb6a,#43a047);">
                                                <i class="bi bi-wallet2 text-white fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Pay with Travel Credit</h6>
                                                <p class="small text-muted mb-0">Earned from cancelled online bookings</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-3"
                                             style="background: #fff; border: 1px solid #c8e6c9;">
                                            <span class="text-muted small">Your credit balance</span>
                                            <span class="fw-bold text-success fs-5">USD {{ number_format($creditBalance, 2) }}</span>
                                        </div>
                                        @if($creditBalance >= ($bookingData['total_price'] ?? 0))
                                        <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: #e8f5e9; border: 1px solid #a5d6a7;">
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                            <span class="small fw-medium text-success">
                                                Your credit covers the full booking amount of USD {{ number_format($bookingData['total_price'] ?? 0, 2) }}.
                                                No additional payment required.
                                            </span>
                                        </div>
                                        @else
                                        <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: #fff3e0; border: 1px solid #ffcc02;">
                                            <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                                            <span class="small fw-medium" style="color:#e65100;">
                                                Insufficient credit. You need USD {{ number_format(($bookingData['total_price'] ?? 0) - $creditBalance, 2) }} more.
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @endif
                            </div>
                        </div>

                        <!-- Step 3: Cancellation Policy -->
                        <div class="checkout-card mb-4">
                            <div class="checkout-card-header">
                                <div class="checkout-step-badge">3</div>
                                <div>
                                    <h5 class="fw-bold mb-0">Cancellation Policy</h5>
                                    <p class="text-muted small mb-0">Know before you go</p>
                                </div>
                            </div>
                            <div class="checkout-card-body">
                                @if($bookingData['free_cancellation'] ?? false)
                                <div class="cancellation-policy-box free">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="cancellation-icon bg-success-subtle text-success">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-success mb-1">Free Cancellation</h6>
                                            <p class="small text-muted mb-1">
                                                Cancel for free before
                                                <strong>{{ \Carbon\Carbon::parse($bookingData['cancellation_deadline'] ?? now())->format('M d, Y') }}</strong>
                                            </p>
                                            <p class="small text-muted mb-0">After this date, cancellation fees may apply.</p>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="cancellation-policy-box non-refundable">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="cancellation-icon bg-danger-subtle text-danger">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-danger mb-1">Non-Refundable</h6>
                                            <p class="small text-muted mb-0">This booking cannot be cancelled or modified once confirmed. No refund will be issued.</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                    <label class="form-check-label small" for="agreeTerms">
                                        I agree to the <a href="#" class="text-decoration-underline">Terms & Conditions</a>,
                                        <a href="#" class="text-decoration-underline">Privacy Policy</a>, and the cancellation policy above.
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if(session()->get('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <a href="{{ route('booking.success') }}" class="btn btn-primary">overide checkout</a>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary-custom btn-hover-glow text-white w-100 py-3 fw-bold checkout-submit-btn" style="font-size: 1.1rem;" id="completeBookingBtn">
                            <i class="bi bi-lock me-2"></i>Complete Booking
                        </button>
                        <p class="text-center text-muted small mt-3">
                            <i class="bi bi-shield-lock me-1"></i>Your payment is secured with 256-bit SSL encryption
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="paymentOverlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="position:relative; width:500px; max-width:95vw; height:80vh; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 8px 32px rgba(0,0,0,0.25);">
        <button type="button" onclick="closePaymentOverlay()" style="position:absolute; top:10px; right:14px; z-index:10; background:none; border:none; font-size:1.5rem; cursor:pointer; color:#666;">&times;</button>
        <div id="content" style="width:100%; height:100%;"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function closePaymentOverlay() {
        const overlay = document.getElementById('paymentOverlay');
        overlay.style.display = 'none';
        document.getElementById('content').innerHTML = '';
    }
    function selectCheckoutPayment(method) {
        document.querySelectorAll('.checkout-pay-tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.method === method);
        });
        document.querySelectorAll('.checkout-payment-section').forEach(section => {
            section.classList.add('d-none');
        });
        const section = document.getElementById('paySection_' + method);
        if (section) section.classList.remove('d-none');
        const input = document.getElementById('checkoutPaymentMethod');
        if (input) input.value = method;
    }
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const paymentMethod = document.getElementById('checkoutPaymentMethod')?.value || 'bitpay';

        // Travel Credit: change action and submit normally — no BoomFi overlay
        if (paymentMethod === 'credit') {
            const btn = document.getElementById('completeBookingBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing Credit Payment...';
            this.action = '{{ route("booking.process.credit") }}';
            this.submit();
            return;
        }

        const btn = document.getElementById('completeBookingBtn');
        const content = document.getElementById('content');
        content.innerHTML = `
            <div class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-muted"><i class="bi bi-info-circle me-1"></i>Processing your payment, please wait...</p>
            </div>
        `;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

        document.getElementById('paymentOverlay').style.display = 'flex';

        const formData = new FormData(this);

        $.ajax({
            url: this.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log('Payment URL response:', response);
                if (response.url) {
                    content.innerHTML = `<iframe id="paymentIframe" src="${response.url}" style="width: 100%; height: 100%; border: none;"></iframe>`;
                    document.getElementById('paymentOverlay').style.display = 'flex';
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-lock me-2"></i>Complete Booking';
                }
            },
            error: function(xhr) {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-lock me-2"></i>Complete Booking';
                closePaymentOverlay();
                let msg = 'Something went wrong. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    msg = xhr.responseJSON.error;
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                alert(msg);
            }
        });
    });
</script>
</body>
</html>
