@extends('layouts.app')
@section('content')

<section class="py-4">
    <div class="container">
        <div class="checkout-page">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Search</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>

            <div class="row g-4">
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
                                        <span>Crypto (BitPay)</span>
                                    </button>
                                    <button type="button" class="checkout-pay-tab" data-method="card" onclick="selectCheckoutPayment('card')">
                                        <i class="bi bi-credit-card"></i>
                                        <span>Credit/Debit Card</span>
                                    </button>
                                </div>

                                <input type="hidden" name="payment_method" id="checkoutPaymentMethod" value="bitpay">

                                <!-- BitPay Section -->
                                <div class="checkout-payment-section" id="paySection_bitpay">
                                    <div class="crypto-payment-box">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="crypto-icon-circle">
                                                <i class="bi bi-currency-bitcoin"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Pay with Cryptocurrency</h6>
                                                <p class="small text-muted mb-0">Bitcoin, Ethereum, and 100+ cryptos accepted via BitPay</p>
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

                                <!-- Card Section -->
                                <div class="checkout-payment-section d-none" id="paySection_card">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-medium small">Card Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                                <input type="text" class="form-control checkout-input" placeholder="1234 5678 9012 3456" maxlength="19">
                                            </div>
                                            <div class="d-flex gap-2 mt-2">
                                                <img src="https://img.icons8.com/color/32/visa.png" alt="Visa" class="card-brand-icon">
                                                <img src="https://img.icons8.com/color/32/mastercard-logo.png" alt="MC" class="card-brand-icon">
                                                <img src="https://img.icons8.com/color/32/amex.png" alt="Amex" class="card-brand-icon">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium small">Expiry Date</label>
                                            <input type="text" class="form-control checkout-input" placeholder="MM / YY" maxlength="7">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium small">CVV</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control checkout-input" placeholder="•••" maxlength="4">
                                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium small">Name on Card</label>
                                            <input type="text" class="form-control checkout-input" placeholder="Full name as shown on card">
                                        </div>
                                    </div>
                                </div>
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

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary-custom btn-hover-glow text-white w-100 py-3 fw-bold checkout-submit-btn" style="font-size: 1.1rem;" id="completeBookingBtn">
                            <i class="bi bi-lock me-2"></i>Complete Booking
                        </button>
                        <p class="text-center text-muted small mt-3">
                            <i class="bi bi-shield-lock me-1"></i>Your payment is secured with 256-bit SSL encryption
                        </p>
                    </form>
                </div>

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
                                <span class="badge bg-primary-subtle text-primary"><i class="bi bi-cup-hot me-1"></i>Breakfast Included</span>
                                @endif
                                @if($bookingData['free_cancellation'] ?? false)
                                <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Free Cancellation</span>
                                @endif
                            </div>

                            <hr>

                            <!-- Price Breakdown -->
                            <div class="checkout-price-breakdown">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Room rate ({{ $nights }} night{{ $nights > 1 ? 's' : '' }})</span>
                                    <span class="small fw-medium">US${{ number_format($bookingData['price_per_night'] * $nights, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Price per night</span>
                                    <span class="small fw-medium">US${{ number_format($bookingData['price_per_night'], 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Taxes & fees</span>
                                    <span class="small text-success fw-medium">Included</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Total Price</span>
                                    <span class="fw-bold checkout-total-price">US${{ number_format($bookingData['total_price'], 2) }}</span>
                                </div>
                                <small class="text-muted d-block mt-1">Including taxes and fees</small>
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
            </div>
        </div>
    </div>
</section>

<script>
    function selectCheckoutPayment(method) {
        // Update tabs
        document.querySelectorAll('.checkout-pay-tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.method === method);
        });

        // Update sections
        document.querySelectorAll('.checkout-payment-section').forEach(section => {
            section.classList.add('d-none');
        });
        const section = document.getElementById('paySection_' + method);
        if (section) section.classList.remove('d-none');

        // Update hidden input
        const input = document.getElementById('checkoutPaymentMethod');
        if (input) input.value = method;
    }

    // Form submission loading state
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('completeBookingBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    });
</script>

@endsection
