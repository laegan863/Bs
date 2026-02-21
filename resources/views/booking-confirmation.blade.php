@extends('layouts.app')
@section('content')

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="confirmation-card text-center">
                    <!-- Success Icon -->
                    <div class="confirmation-icon-wrapper mb-4">
                        <div class="confirmation-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    </div>

                    <h2 class="fw-bold mb-2" style="color: var(--primary-navy);">Booking Confirmed!</h2>
                    <p class="text-muted mb-4">Your reservation has been successfully processed. A confirmation email has been sent to <strong>{{ $booking->guest_email }}</strong>.</p>

                    <!-- Booking Reference -->
                    <div class="confirmation-reference mb-4">
                        <small class="text-muted d-block mb-1">Booking Reference</small>
                        <span class="fw-bold" style="font-size: 1.3rem; color: var(--primary-navy); letter-spacing: 2px;">{{ $booking->transaction_reference }}</span>
                    </div>

                    <!-- Booking Details Card -->
                    <div class="confirmation-details">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="confirmation-detail-block">
                                    <i class="bi bi-building mb-2 d-block" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
                                    <small class="text-muted d-block">Hotel</small>
                                    <span class="fw-bold small">{{ $booking->property_name }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="confirmation-detail-block">
                                    <i class="bi bi-door-open mb-2 d-block" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
                                    <small class="text-muted d-block">Room</small>
                                    <span class="fw-bold small">{{ $booking->room_name }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="confirmation-detail-block">
                                    <i class="bi bi-credit-card mb-2 d-block" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
                                    <small class="text-muted d-block">Payment</small>
                                    <span class="fw-bold small">
                                        @if($booking->payment_method === 'bitpay')
                                            Cryptocurrency (BitPay)
                                        @elseif($booking->payment_method === 'card')
                                            Credit/Debit Card
                                        @else
                                            Pay at Hotel
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row g-3 text-start px-4 py-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Check-in</small>
                                <span class="fw-medium small">{{ $booking->check_in->format('D, M d, Y') }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Check-out</small>
                                <span class="fw-medium small">{{ $booking->check_out->format('D, M d, Y') }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Guest</small>
                                <span class="fw-medium small">{{ $booking->guest_first_name }} {{ $booking->guest_last_name }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center px-4 py-3">
                            <span class="fw-bold">Total Paid</span>
                            <span class="fw-bold" style="font-size: 1.3rem; color: var(--primary-navy);">US${{ number_format($booking->total_price, 2) }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-3 justify-content-center mt-4">
                        <a href="{{ route('landing') }}" class="btn btn-outline-secondary px-4 py-2 fw-medium">
                            <i class="bi bi-house me-1"></i> Back to Home
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary-custom btn-hover-glow text-white px-4 py-2 fw-medium">
                            <i class="bi bi-grid me-1"></i> View My Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
