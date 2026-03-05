@extends('layouts.dashboard')
@section('page-title', 'My Bookings')

@section('dashboard-content')
<div class="profile-content-card">
    <!-- Header -->
    <div class="profile-header d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">My Bookings</h4>
    </div>

    <!-- Booking Tabs -->
    <ul class="nav nav-pills mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="pill" href="#currentBookings">
                <i class="bi bi-calendar-check me-1"></i> Current Bookings
                <span class="badge bg-primary ms-1">{{ $currentBookings->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="pill" href="#previousBookings">
                <i class="bi bi-clock-history me-1"></i> Previous Bookings
                <span class="badge bg-secondary ms-1">{{ $previousBookings->count() }}</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Current Bookings -->
        <div class="tab-pane fade show active" id="currentBookings">
            @if($currentBookings->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x display-4 text-muted"></i>
                    <h5 class="mt-3 text-muted">No Current Bookings</h5>
                    <p class="text-muted small">You don't have any upcoming bookings at the moment.</p>
                    <a href="{{ route('landing') }}" class="btn btn-primary btn-sm mt-2">
                        <i class="bi bi-search me-1"></i> Search Hotels
                    </a>
                </div>
            @else
                @foreach($currentBookings as $booking)
                    <div class="booking-card mb-3">
                        <div class="row g-0">
                            <div class="col-md-12">
                                <div class="booking-card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $booking->property_name }}</h5>
                                            <p class="text-muted small mb-0">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $booking->property_address ?? '' }}
                                                @if($booking->property_city), {{ $booking->property_city }}@endif
                                                @if($booking->property_country), {{ $booking->property_country }}@endif
                                            </p>
                                        </div>
                                        <span class="badge {{ $booking->status_badge_class }} rounded-pill px-3 py-2">
                                            {{ $booking->status_label }}
                                        </span>
                                    </div>

                                    <hr class="my-2">

                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Check-in</small>
                                            <span class="fw-medium">{{ $booking->check_in->format('d M Y') }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Check-out</small>
                                            <span class="fw-medium">{{ $booking->check_out->format('d M Y') }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Room</small>
                                            <span class="fw-medium">{{ $booking->room_type ?? $booking->room_name }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Guests</small>
                                            <span class="fw-medium">{{ $booking->adults }} Adult{{ $booking->adults > 1 ? 's' : '' }}{{ $booking->children ? ', ' . $booking->children . ' Child' . ($booking->children > 1 ? 'ren' : '') : '' }}</span>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Total Price</small>
                                            <span class="fw-bold text-primary">{{ $booking->currency }} {{ number_format($booking->selling_price ?? $booking->total_price, 2) }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Booking ID</small>
                                            <span class="fw-medium">#{{ $booking->agoda_booking_id ?? $booking->id }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Nights</small>
                                            <span class="fw-medium">{{ $booking->nights }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Rooms</small>
                                            <span class="fw-medium">{{ $booking->rooms }}</span>
                                        </div>
                                    </div>

                                    @if($booking->room_benefits && count($booking->room_benefits) > 0)
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Benefits</small>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($booking->room_benefits as $benefit)
                                                <span class="badge bg-light text-dark border">
                                                    <i class="bi bi-check-circle text-success me-1"></i>
                                                    {{ $benefit['benefitName'] ?? $benefit }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    @if($booking->special_requests)
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Special Request</small>
                                        <span class="small">{{ $booking->special_requests }}</span>
                                    </div>
                                    @endif

                                    <!-- Actions -->
                                    <div class="d-flex gap-2 mt-3">
                                        @if($booking->isCancellable())
                                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-x-circle me-1"></i> Cancel Booking
                                                </button>
                                            </form>
                                        @endif

                                        @if($booking->isAmendable())
                                            <a href="{{ route('bookings.amend', $booking) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-pencil-square me-1"></i> Reschedule
                                            </a>
                                        @endif

                                        @if($booking->self_service_url)
                                            <a href="{{ $booking->self_service_url }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-box-arrow-up-right me-1"></i> Manage on Agoda
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Previous Bookings -->
        <div class="tab-pane fade" id="previousBookings">
            @if($previousBookings->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-clock-history display-4 text-muted"></i>
                    <h5 class="mt-3 text-muted">No Previous Bookings</h5>
                    <p class="text-muted small">Your past bookings will appear here.</p>
                </div>
            @else
                @foreach($previousBookings as $booking)
                    <div class="booking-card booking-card-past mb-3">
                        <div class="row g-0">
                            <div class="col-md-12">
                                <div class="booking-card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $booking->property_name }}</h5>
                                            <p class="text-muted small mb-0">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $booking->property_address ?? '' }}
                                                @if($booking->property_city), {{ $booking->property_city }}@endif
                                                @if($booking->property_country), {{ $booking->property_country }}@endif
                                            </p>
                                        </div>
                                        <span class="badge {{ $booking->status_badge_class }} rounded-pill px-3 py-2">
                                            {{ $booking->status_label }}
                                        </span>
                                    </div>

                                    <hr class="my-2">

                                    <div class="row g-3">
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Check-in</small>
                                            <span class="fw-medium">{{ $booking->check_in->format('d M Y') }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Check-out</small>
                                            <span class="fw-medium">{{ $booking->check_out->format('d M Y') }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Room</small>
                                            <span class="fw-medium">{{ $booking->room_type ?? $booking->room_name }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Total Price</small>
                                            <span class="fw-bold">{{ $booking->currency }} {{ number_format($booking->selling_price ?? $booking->total_price, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="row g-3 mt-1">
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Booking ID</small>
                                            <span class="fw-medium">#{{ $booking->agoda_booking_id ?? $booking->id }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted d-block">Booked on</small>
                                            <span class="fw-medium">{{ $booking->agoda_booking_date ? $booking->agoda_booking_date->format('d M Y') : $booking->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
