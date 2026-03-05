@extends('layouts.dashboard')
@section('page-title', $tab === 'previous' ? 'Previous Bookings' : 'Upcoming Bookings')

@section('dashboard-content')
<div class="profile-content-card">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tab Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            @if($tab === 'previous')
                <h4 class="fw-bold mb-1" style="color: var(--primary-navy);">
                    <i class="bi bi-clock-history me-2"></i>Previous Bookings
                </h4>
                <p class="text-muted small mb-0">Give feedback to previous bookings and rebook the hotel rooms</p>
            @else
                <h4 class="fw-bold mb-1" style="color: var(--primary-navy);">
                    <i class="bi bi-calendar-check me-2"></i>Upcoming Bookings
                </h4>
                <p class="text-muted small mb-0">Manage your upcoming reservations</p>
            @endif
        </div>
    </div>

    @if($tab === 'previous')
        {{-- ======================== Previous Bookings ======================== --}}
        @if($previousBookings->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-clock-history" style="font-size: 3rem; color: #ccc;"></i>
                <h5 class="mt-3 fw-bold">No Previous Bookings</h5>
                <p class="text-muted">You don't have any past bookings yet.</p>
                <a href="{{ route('landing') }}" class="btn btn-primary-custom text-white px-4 py-2 mt-2">
                    <i class="bi bi-search me-1"></i> Find a Hotel
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($previousBookings as $booking)
                <div class="col-md-6 col-xl-4">
                    <div class="booking-card h-100">
                        <div class="booking-card-image">
                            <img src="{{ $booking->property_image ?: asset('assets/images/login-1.jpg') }}" alt="{{ $booking->property_name }}">
                            <div class="booking-card-status-badge">
                                <span class="badge {{ $booking->status === 'completed' ? 'bg-secondary' : ($booking->status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="booking-card-body">
                            <h6 class="fw-bold mb-1">{{ $booking->property_name }}</h6>
                            <p class="small text-muted mb-2">{{ $booking->room_name }}</p>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="small text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $booking->check_in->format('M d') }} - {{ $booking->check_out->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fw-bold" style="color: var(--primary-navy);">${{ number_format($booking->price_per_night, 0) }}</span>
                                    <small class="text-muted">avg. nightly price</small>
                                </div>
                            </div>
                            @if($booking->free_cancellation && $booking->cancellation_deadline)
                                <p class="small text-muted mt-1 mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Fully refundable before {{ $booking->cancellation_deadline->format('D, M d') }}
                                </p>
                            @endif

                            {{-- Agoda Booking Info --}}
                            @if($booking->agodaBooking)
                                <p class="small text-muted mt-1 mb-0">
                                    <i class="bi bi-hash me-1"></i>Agoda ID: {{ $booking->agodaBooking->agoda_booking_id }}
                                </p>
                            @endif

                            <div class="d-flex gap-2 mt-3">
                                <a href="#" class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="bi bi-star me-1"></i>Rate
                                </a>
                                <a href="{{ route('landing') }}" class="btn btn-sm btn-primary-custom text-white flex-fill">
                                    <i class="bi bi-arrow-repeat me-1"></i>Rebook
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    @else
        {{-- ======================== Upcoming Bookings ======================== --}}
        @if($upcomingBookings->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
                <h5 class="mt-3 fw-bold">No Upcoming Bookings</h5>
                <p class="text-muted">You don't have any upcoming reservations.</p>
                <a href="{{ route('landing') }}" class="btn btn-primary-custom text-white px-4 py-2 mt-2">
                    <i class="bi bi-search me-1"></i> Find a Hotel
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($upcomingBookings as $booking)
                <div class="col-md-6 col-xl-4">
                    <div class="booking-card h-100">
                        <div class="booking-card-image">
                            <img src="{{ $booking->property_image ?: asset('assets/images/login-1.jpg') }}" alt="{{ $booking->property_name }}">
                            <div class="booking-card-status-badge">
                                <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="booking-card-body">
                            <h6 class="fw-bold mb-1">{{ $booking->property_name }}</h6>
                            <p class="small text-muted mb-2">{{ $booking->room_name }}</p>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="small text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $booking->check_in->format('M d') }} - {{ $booking->check_out->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fw-bold" style="color: var(--primary-navy);">${{ number_format($booking->price_per_night, 0) }}</span>
                                    <small class="text-muted">avg. nightly price</small>
                                </div>
                            </div>
                            @if($booking->free_cancellation && $booking->cancellation_deadline)
                                <p class="small text-success mt-1 mb-0">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Fully refundable before {{ $booking->cancellation_deadline->format('D, M d') }}
                                </p>
                            @endif

                            {{-- Agoda Booking Info --}}
                            @if($booking->agodaBooking)
                                <p class="small text-muted mt-1 mb-0">
                                    <i class="bi bi-hash me-1"></i>Agoda ID: {{ $booking->agodaBooking->agoda_booking_id }}
                                </p>
                            @endif

                            <div class="mt-3">
                                @if($booking->isCancellable())
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-danger w-100">
                                            <i class="bi bi-x-circle me-1"></i>Cancel Booking
                                        </button>
                                    </form>
                                @else
                                    <div class="text-center py-2 px-3 rounded-3" style="background: #fff3f3;">
                                        <small class="text-danger fw-medium">
                                            <i class="bi bi-lock me-1"></i>Non-refundable — cancellation not available
                                        </small>
                                    </div>
                                @endif


                                {{-- View Details Button --}}
                                <button class="btn btn-primary fw-semibold w-100 mt-2"
                                    onclick="fetchBookingDetail({{ $booking->id }})">
                                    <i class="bi bi-eye me-1"></i>View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    @endif
</div>

{{-- Booking Detail Modal --}}
<div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-labelledby="bookingDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">

            {{-- Gradient Header --}}
            <div class="modal-header border-0 text-white px-4 py-3" style="background: linear-gradient(135deg, var(--primary-navy, #1a1a5e) 0%, var(--primary-blue, #3366cc) 100%);">
                <div>
                    <h5 class="modal-title fw-bold mb-0" id="bookingDetailModalLabel">
                        <i class="bi bi-journal-bookmark-fill me-2"></i>Booking Details
                    </h5>
                    <small class="opacity-75" id="dtHeaderSubtext">Loading...</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-0 py-0" id="bookingDetailBody">
                {{-- Loading spinner --}}
                <div id="detailLoading" class="text-center py-5">
                    <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted fw-medium">Fetching booking details from Agoda...</p>
                </div>
                {{-- Error state --}}
                <div id="detailError" class="d-none text-center py-5 px-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 70px; height: 70px; background: #fff0f0;">
                        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="fw-bold">Something went wrong</h6>
                    <p class="text-muted small" id="detailErrorMsg">Failed to load booking details.</p>
                </div>
                {{-- Content --}}
                <div id="detailContent" class="d-none">

                    {{-- Status Banner --}}
                    <div class="px-4 py-3 d-flex align-items-center justify-content-between" id="dtStatusBanner" style="background: #f0fdf4;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-patch-check-fill text-success" id="dtStatusIcon" style="font-size: 1.3rem;"></i>
                            <span class="fw-semibold" id="dtAgodaStatus">-</span>
                        </div>
                        <span class="badge rounded-pill px-3 py-2" id="dtAgodaIdBadge" style="background: var(--primary-navy, #1a1a5e); font-size: 0.75rem;">
                            #<span id="dtAgodaId">-</span>
                        </span>
                    </div>

                    {{-- Property & Room Card --}}
                    <div class="px-4 pt-4 pb-2">
                        <div class="dt-section-card">
                            <div class="d-flex align-items-start gap-3">
                                <div class="dt-section-icon" style="background: linear-gradient(135deg, #e8eaf6, #c5cae9);">
                                    <i class="bi bi-building" style="color: var(--primary-navy, #1a1a5e);"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1" id="dtPropName">-</h6>
                                    <p class="text-muted small mb-2" id="dtAddress">-</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="dt-info-chip"><i class="bi bi-geo-alt me-1"></i><span id="dtCity">-</span>, <span id="dtCountry">-</span></span>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3" style="border-color: #eee;">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="dt-info-block">
                                        <span class="dt-label"><i class="bi bi-door-open me-1"></i>Room Type</span>
                                        <span class="dt-value" id="dtRoomType">-</span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="dt-info-block">
                                        <span class="dt-label">Rooms</span>
                                        <span class="dt-value" id="dtRoomsBooked">-</span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="dt-info-block">
                                        <span class="dt-label">Rate Plan</span>
                                        <span class="dt-value" id="dtRatePlan">-</span>
                                    </div>
                                </div>
                            </div>
                            {{-- Benefits --}}
                            <div class="mt-3" id="dtBenefitsWrap" style="display:none">
                                <span class="dt-label mb-2 d-block">Included Benefits</span>
                                <div id="dtBenefits" class="d-flex flex-wrap gap-2"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Stay Dates & Occupancy --}}
                    <div class="px-4 py-2">
                        <div class="row g-3">
                            {{-- Dates --}}
                            <div class="col-md-7">
                                <div class="dt-section-card h-100">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <div class="dt-section-icon-sm" style="background: #e3f2fd;">
                                            <i class="bi bi-calendar-event text-primary"></i>
                                        </div>
                                        <span class="fw-semibold small" style="color: var(--primary-navy, #1a1a5e);">Stay Details</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <div class="text-center flex-fill">
                                            <span class="d-block text-muted" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">Check-in</span>
                                            <span class="fw-bold" id="dtCheckIn" style="color: var(--primary-navy, #1a1a5e);">-</span>
                                        </div>
                                        <div class="text-center px-3">
                                            <i class="bi bi-arrow-right text-muted"></i>
                                        </div>
                                        <div class="text-center flex-fill">
                                            <span class="d-block text-muted" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">Check-out</span>
                                            <span class="fw-bold" id="dtCheckOut" style="color: var(--primary-navy, #1a1a5e);">-</span>
                                        </div>
                                    </div>
                                    <div class="text-center small text-muted">
                                        <i class="bi bi-clock me-1"></i>Booked on <span id="dtBookingDate">-</span>
                                    </div>
                                </div>
                            </div>
                            {{-- Occupancy --}}
                            <div class="col-md-5">
                                <div class="dt-section-card h-100">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <div class="dt-section-icon-sm" style="background: #fce4ec;">
                                            <i class="bi bi-people text-danger"></i>
                                        </div>
                                        <span class="fw-semibold small" style="color: var(--primary-navy, #1a1a5e);">Guests</span>
                                    </div>
                                    <div class="d-flex gap-3 mb-2">
                                        <div>
                                            <span class="d-block text-muted" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">Adults</span>
                                            <span class="fw-bold" id="dtAdults" style="font-size: 1.1rem;">-</span>
                                        </div>
                                        <div>
                                            <span class="d-block text-muted" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">Children</span>
                                            <span class="fw-bold" id="dtChildren" style="font-size: 1.1rem;">-</span>
                                        </div>
                                    </div>
                                    <div id="dtSpecialReqWrap">
                                        <span class="d-block text-muted" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">Special Request</span>
                                        <span class="small fst-italic" id="dtSpecialReq">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pricing Card --}}
                    <div class="px-4 py-2">
                        <div class="dt-section-card" style="background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%); border: 1px solid #e0e7ff;">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="dt-section-icon-sm" style="background: #e8eaf6;">
                                    <i class="bi bi-wallet2" style="color: var(--primary-navy, #1a1a5e);"></i>
                                </div>
                                <span class="fw-semibold small" style="color: var(--primary-navy, #1a1a5e);">Payment Summary</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">Room Rate (excl.)</span>
                                <span class="fw-medium" id="dtRateExcl">-</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">Tax</span>
                                <span class="fw-medium" id="dtRateTax">-</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted small">Fees</span>
                                <span class="fw-medium" id="dtRateFees">-</span>
                            </div>
                            <hr style="border-style: dashed; border-color: #c5cae9;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Total (incl. tax & fees)</span>
                                <span class="fw-bold fs-5" id="dtTotal" style="color: var(--primary-navy, #1a1a5e);">-</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Payment Card</span>
                                <span class="small fw-medium" id="dtPaymentCard"><i class="bi bi-credit-card me-1"></i>-</span>
                            </div>
                            <div class="mt-2 small text-muted fst-italic" id="dtTaxInfo">-</div>
                        </div>
                    </div>

                    {{-- Booking Reference & Source --}}
                    <div class="px-4 py-2">
                        <div class="dt-section-card">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="dt-section-icon-sm" style="background: #fff3e0;">
                                    <i class="bi bi-bookmark-star text-warning"></i>
                                </div>
                                <span class="fw-semibold small" style="color: var(--primary-navy, #1a1a5e);">Booking Reference</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="dt-info-block">
                                        <span class="dt-label">Hotel Confirmation #</span>
                                        <span class="dt-value font-monospace" id="dtHotelConfirm">-</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="dt-info-block">
                                        <span class="dt-label">Supplier Reference</span>
                                        <span class="dt-value" id="dtSupplierRef">-</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="dt-info-block">
                                        <span class="dt-label">Source</span>
                                        <span class="dt-value" id="dtSource">-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3" id="dtSelfServiceWrap" style="display:none">
                                <a href="#" id="dtSelfService" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>Manage on Agoda
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Cancellation Policy --}}
                    <div class="px-4 pt-2 pb-4">
                        <div class="dt-section-card" id="dtCancelPolicyCard" style="background: #fff8f0; border: 1px solid #ffe0b2;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="dt-section-icon-sm" style="background: #ffecb3;">
                                    <i class="bi bi-shield-exclamation text-warning"></i>
                                </div>
                                <span class="fw-semibold small" style="color: var(--primary-navy, #1a1a5e);">Cancellation Policy</span>
                            </div>
                            <p class="mb-0 small text-muted" id="dtCancellationPolicy" style="line-height: 1.7;">-</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer border-0 px-4 py-3" style="background: #fafbfc;">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-medium" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .booking-card {
        border: 1px solid #e9ecef;
        border-radius: 16px;
        overflow: hidden;
        transition: box-shadow 0.2s, transform 0.2s;
        background: #fff;
    }
    .booking-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }
    .booking-card-image {
        position: relative;
        height: 180px;
        overflow: hidden;
    }
    .booking-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .booking-card-status-badge {
        position: absolute;
        top: 12px;
        right: 12px;
    }
    .booking-card-body {
        padding: 16px;
    }

    /* Modal Detail Styles */
    .dt-section-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 14px;
        padding: 18px;
        transition: box-shadow 0.2s;
    }
    .dt-section-card:hover {
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .dt-section-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .dt-section-icon-sm {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .dt-info-chip {
        display: inline-flex;
        align-items: center;
        font-size: 0.72rem;
        color: #666;
        background: #f5f5f5;
        border-radius: 20px;
        padding: 3px 10px;
    }
    .dt-info-block {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .dt-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #999;
        font-weight: 600;
    }
    .dt-value {
        font-weight: 600;
        color: #333;
        font-size: 0.88rem;
    }
    .dt-benefit-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.72rem;
        font-weight: 500;
    }
    #bookingDetailModal .modal-body {
        max-height: 72vh;
        overflow-y: auto;
    }
    #bookingDetailModal .modal-body::-webkit-scrollbar {
        width: 5px;
    }
    #bookingDetailModal .modal-body::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
function fetchBookingDetail(bookingId) {
    const modal = new bootstrap.Modal(document.getElementById('bookingDetailModal'));
    document.getElementById('detailLoading').classList.remove('d-none');
    document.getElementById('detailError').classList.add('d-none');
    document.getElementById('detailContent').classList.add('d-none');
    modal.show();

    fetch(`/bookings/${bookingId}/detail`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => { if (!r.ok) throw new Error('Request failed'); return r.json(); })
    .then(data => {
        document.getElementById('detailLoading').classList.add('d-none');
        document.getElementById('detailContent').classList.remove('d-none');

        const a = data.agoda;

        if (!a) {
            document.getElementById('detailContent').classList.add('d-none');
            document.getElementById('detailError').classList.remove('d-none');
            document.getElementById('detailErrorMsg').textContent = 'No Agoda booking data available.';
            return;
        }

        // Header subtext
        document.getElementById('dtHeaderSubtext').textContent = (a.property?.propertyName || '') + ' • ' + (a.checkIn || '');

        // Status banner
        const statusBanner = document.getElementById('dtStatusBanner');
        const statusIcon = document.getElementById('dtStatusIcon');
        const statusText = (a.status || 'Unknown');
        if (statusText.toLowerCase().includes('cancel')) {
            statusBanner.style.background = '#fff0f0';
            statusIcon.className = 'bi bi-x-circle-fill text-danger';
            statusIcon.style.fontSize = '1.3rem';
        } else if (statusText.toLowerCase().includes('charged') || statusText.toLowerCase().includes('confirm')) {
            statusBanner.style.background = '#f0fdf4';
            statusIcon.className = 'bi bi-patch-check-fill text-success';
            statusIcon.style.fontSize = '1.3rem';
        } else {
            statusBanner.style.background = '#fff8e1';
            statusIcon.className = 'bi bi-hourglass-split text-warning';
            statusIcon.style.fontSize = '1.3rem';
        }

        // Property
        const prop = a.property || {};
        document.getElementById('dtPropName').textContent = prop.propertyName || '-';
        const addrParts = [prop.addressLine1, prop.addressLine2].filter(Boolean);
        document.getElementById('dtAddress').textContent = addrParts.length ? addrParts.join(', ') : '-';
        document.getElementById('dtCity').textContent = prop.city || '-';
        document.getElementById('dtCountry').textContent = prop.country || '-';

        // Room
        const room = a.room || {};
        document.getElementById('dtRoomType').textContent = room.roomType || '-';
        document.getElementById('dtRoomsBooked').textContent = room.roomsBooked ?? '-';
        document.getElementById('dtRatePlan').textContent = room.ratePlan || '-';
        document.getElementById('dtSource').textContent = a.source || '-';

        // Benefits
        const benefitsEl = document.getElementById('dtBenefits');
        benefitsEl.innerHTML = '';
        if (room.benefits && room.benefits.length) {
            document.getElementById('dtBenefitsWrap').style.display = 'block';
            room.benefits.forEach(b => {
                const badge = document.createElement('span');
                badge.className = 'dt-benefit-badge';
                badge.innerHTML = '<i class="bi bi-check-circle-fill"></i>' + b.benefitName;
                benefitsEl.appendChild(badge);
            });
        } else {
            document.getElementById('dtBenefitsWrap').style.display = 'none';
        }

        // Dates
        document.getElementById('dtCheckIn').textContent = a.checkIn || '-';
        document.getElementById('dtCheckOut').textContent = a.checkOut || '-';
        document.getElementById('dtBookingDate').textContent = a.bookingDate ? new Date(a.bookingDate).toLocaleString() : '-';

        // Occupancy
        const occ = a.occupancy || {};
        document.getElementById('dtAdults').textContent = occ.numberOfAdults ?? '-';
        document.getElementById('dtChildren').textContent = occ.numberOfChildren ?? '-';
        document.getElementById('dtSpecialReq').textContent = a.specialRequest || '-';

        // Pricing (from totalRates array)
        const rate = (a.totalRates && a.totalRates[0]) || {};
        const cur = rate.currency || '';
        document.getElementById('dtRateExcl').textContent = cur + ' ' + (parseFloat(rate.exclusive) || 0).toFixed(2);
        document.getElementById('dtRateTax').textContent = cur + ' ' + (parseFloat(rate.tax) || 0).toFixed(2);
        document.getElementById('dtRateFees').textContent = cur + ' ' + (parseFloat(rate.fees) || 0).toFixed(2);
        document.getElementById('dtTotal').textContent = cur + ' ' + (parseFloat(rate.inclusive) || 0).toFixed(2);

        // Payment
        const pay = a.payment || {};
        document.getElementById('dtPaymentCard').innerHTML = pay.creditCardNumber ? '<i class="bi bi-credit-card me-1"></i>' + pay.creditCardNumber : '-';
        document.getElementById('dtTaxInfo').textContent = a.taxSurchargeInfo || '-';

        // Agoda Booking Info
        document.getElementById('dtAgodaId').textContent = a.bookingId || '-';
        document.getElementById('dtAgodaStatus').textContent = a.status || '-';
        document.getElementById('dtHotelConfirm').textContent = a.hotelConfirmationNumber || '-';
        document.getElementById('dtSupplierRef').textContent = a.supplierReference || '-';

        // Self-service link
        if (a.selfService) {
            document.getElementById('dtSelfServiceWrap').style.display = 'block';
            document.getElementById('dtSelfService').href = a.selfService;
        } else {
            document.getElementById('dtSelfServiceWrap').style.display = 'none';
        }

        // Cancellation policy
        document.getElementById('dtCancellationPolicy').textContent = a.cancellationPolicy || 'Not available';
    })
    .catch(err => {
        document.getElementById('detailLoading').classList.add('d-none');
        document.getElementById('detailError').classList.remove('d-none');
        document.getElementById('detailErrorMsg').textContent = 'Failed to load booking details. ' + err.message;
    });
}
</script>
@endpush
@endsection
