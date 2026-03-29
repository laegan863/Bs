@extends('layouts.app')
@section('content')

@php
    $detail = $booking->bookingDetail;
@endphp

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
                        @if($booking->agodaBooking)
                        <div class="d-inline-block px-4 py-3 mb-3 rounded-4" style="background: linear-gradient(135deg, var(--primary-navy, #1a1a5e) 0%, var(--primary-blue, #3366cc) 100%); min-width: 280px;">
                            <small class="d-block mb-1 text-white-50" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Agoda Booking ID</small>
                            <span class="fw-bold text-white" style="font-size: 1.6rem; letter-spacing: 3px;">{{ $booking->agodaBooking->agoda_booking_id }}</span>
                        </div>
                        @endif
                        <div>
                            <small class="text-muted d-block mb-1">Transaction Reference</small>
                            <span class="fw-bold" style="font-size: 1rem; color: var(--primary-navy); letter-spacing: 2px;">{{ $booking->transaction_reference }}</span>
                        </div>
                    </div>

                    <!-- Payment Type Badge -->
                    @if($detail && $detail->payment_type)
                    <div class="mb-4">
                        @if($detail->payment_type === 'pay_at_hotel')
                            <span class="badge bg-warning text-dark px-3 py-2" style="font-size: 0.85rem;">
                                <i class="bi bi-building me-1"></i> Pay At Hotel
                            </span>
                        @else
                            <span class="badge bg-success px-3 py-2" style="font-size: 0.85rem;">
                                <i class="bi bi-check-circle me-1"></i> Pre-paid
                            </span>
                        @endif
                    </div>
                    @endif

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

                        <!-- Hotel Address -->
                        @if($detail && $detail->hotel_address)
                        <div class="text-start px-4 py-2">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-geo-alt-fill mt-1" style="color: var(--primary-blue);"></i>
                                <div>
                                    <small class="text-muted d-block">Hotel Address</small>
                                    <span class="fw-medium small">{{ $detail->hotel_address }}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @endif

                        <!-- Check-in/out, Guest, Status -->
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

                        <!-- Room Type & Quantity -->
                        <div class="row g-3 text-start px-4 py-3">
                            @if($detail && $detail->room_type)
                            <div class="col-6">
                                <small class="text-muted d-block">Room Type</small>
                                <span class="fw-medium small">{{ $detail->room_type }}</span>
                            </div>
                            @endif
                            <div class="col-6">
                                <small class="text-muted d-block">Room Quantity</small>
                                <span class="fw-medium small">{{ $detail->room_quantity ?? $booking->rooms }} room{{ ($detail->room_quantity ?? $booking->rooms) > 1 ? 's' : '' }}</span>
                            </div>
                        </div>

                        <!-- Number of Guests -->
                        <div class="row g-3 text-start px-4 py-2">
                            <div class="col-6">
                                <small class="text-muted d-block">Adults</small>
                                <span class="fw-medium small">{{ $detail->adults ?? $booking->adults }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Children</small>
                                <span class="fw-medium small">{{ $detail->children ?? $booking->children ?? 0 }}</span>
                            </div>
                        </div>

                        <!-- Benefits -->
                        @if($detail && !empty($detail->benefits))
                        <hr>
                        <div class="text-start px-4 py-2">
                            <small class="text-muted d-block mb-2">Benefits</small>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($detail->benefits as $benefit)
                                <span class="badge bg-success-subtle text-success">
                                    <i class="bi bi-check-circle me-1"></i>{{ $benefit }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Cancellation Policy -->
                        @if($detail && $detail->cancellation_policy)
                        <hr>
                        <div class="text-start px-4 py-2">
                            <small class="text-muted d-block mb-1">Cancellation Policy</small>
                            @if($detail->free_cancellation && $detail->cancellation_deadline)
                            <span class="badge bg-success-subtle text-success mb-1">
                                <i class="bi bi-shield-check me-1"></i>Free Cancellation until {{ $detail->cancellation_deadline->format('M d, Y') }}
                            </span>
                            @elseif(!$detail->free_cancellation)
                            <span class="badge bg-danger-subtle text-danger mb-1">
                                <i class="bi bi-x-circle me-1"></i>Non-refundable
                            </span>
                            @endif
                            <p class="small text-muted mb-0 mt-1">{{ $detail->cancellation_policy }}</p>
                        </div>
                        @endif

                        <!-- Special Requests -->
                        @if($detail && $detail->special_requests)
                        <hr>
                        <div class="text-start px-4 py-2">
                            <small class="text-muted d-block mb-1">Special Requests</small>
                            <p class="small mb-0">{{ $detail->special_requests }}</p>
                        </div>
                        @endif

                        <!-- Hotel Remarks -->
                        @if($detail && $detail->hotel_remarks)
                        <hr>
                        <div class="text-start px-4 py-2">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-exclamation-circle text-warning mt-1"></i>
                                <div>
                                    <small class="text-muted d-block mb-1">Hotel Remarks</small>
                                    <p class="small mb-0">{{ $detail->hotel_remarks }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Mandatory & Excluded Surcharges -->
                        @if($detail && !empty($detail->surcharges))
                        <hr>
                        <div class="text-start px-4 py-2">
                            <small class="text-muted d-block mb-2">Mandatory & Excluded Surcharges</small>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0" style="font-size: 0.85rem;">
                                    @foreach($detail->surcharges as $surcharge)
                                    <tr>
                                        <td class="ps-0">
                                            <i class="bi bi-dot text-muted"></i>
                                            {{ $surcharge['name'] ?? 'Surcharge' }}
                                            @if(!empty($surcharge['type']))
                                            <span class="badge bg-light text-muted ms-1" style="font-size: 0.65rem;">{{ ucfirst($surcharge['type']) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-0 fw-medium">
                                            @if(($surcharge['amount'] ?? 0) > 0)
                                                US${{ number_format($surcharge['amount'], 2) }}
                                            @else
                                                Included
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if($detail->surcharge_total > 0)
                                    <tr class="border-top">
                                        <td class="ps-0 fw-bold">Total Surcharges</td>
                                        <td class="text-end pe-0 fw-bold">US${{ number_format($detail->surcharge_total, 2) }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        @endif

                        <hr>

                        <div class="d-flex justify-content-between align-items-center px-4 py-3">
                            <span class="fw-bold">Total Paid</span>
                            <span class="fw-bold" style="font-size: 1.3rem; color: var(--primary-navy);">US${{ number_format($booking->total_price, 2) }}</span>
                        </div>
                    </div>

                    <!-- Customer Services -->
                    <div class="mt-4 p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center gap-2 justify-content-center">
                            <i class="bi bi-headset" style="font-size: 1.2rem; color: var(--primary-blue);"></i>
                            <span class="small fw-medium">Need help? Contact our support team 24/7</span>
                        </div>
                        <p class="small text-muted mb-0 mt-1">Email: support@solanatravels.com | Available around the clock</p>
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
