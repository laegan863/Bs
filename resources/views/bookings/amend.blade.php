@extends('layouts.dashboard')
@section('page-title', 'Reschedule Booking')

@section('dashboard-content')
<div class="profile-content-card">
    <div class="profile-header d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Reschedule Booking</h4>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Bookings
        </a>
    </div>

    <hr class="my-3">

    <!-- Current Booking Info -->
    <div class="bg-light rounded-3 p-3 mb-4">
        <h6 class="fw-bold mb-2">{{ $booking->property_name }}</h6>
        <p class="text-muted small mb-2">
            <i class="bi bi-geo-alt me-1"></i>
            {{ $booking->property_address }}
            @if($booking->property_city), {{ $booking->property_city }}@endif
            @if($booking->property_country), {{ $booking->property_country }}@endif
        </p>
        <div class="row g-3">
            <div class="col-sm-3">
                <small class="text-muted d-block">Current Check-in</small>
                <span class="fw-medium">{{ $booking->check_in->format('d M Y') }}</span>
            </div>
            <div class="col-sm-3">
                <small class="text-muted d-block">Current Check-out</small>
                <span class="fw-medium">{{ $booking->check_out->format('d M Y') }}</span>
            </div>
            <div class="col-sm-3">
                <small class="text-muted d-block">Room</small>
                <span class="fw-medium">{{ $booking->room_type ?? $booking->room_name }}</span>
            </div>
            <div class="col-sm-3">
                <small class="text-muted d-block">Booking ID</small>
                <span class="fw-medium">#{{ $booking->agoda_booking_id ?? $booking->id }}</span>
            </div>
        </div>
    </div>

    <!-- Amendment Form -->
    <form action="{{ route('bookings.amend.submit', $booking) }}" method="POST">
        @csrf
        @method('PATCH')

        <h6 class="fw-bold mb-3">Select New Dates</h6>

        <div class="row g-3 mb-4">
            <div class="col-sm-6">
                <label for="new_check_in" class="form-label">New Check-in Date</label>
                <input type="date" name="new_check_in" id="new_check_in"
                       class="form-control @error('new_check_in') is-invalid @enderror"
                       value="{{ old('new_check_in', $booking->check_in->format('Y-m-d')) }}"
                       min="{{ now()->format('Y-m-d') }}">
                @error('new_check_in')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="new_check_out" class="form-label">New Check-out Date</label>
                <input type="date" name="new_check_out" id="new_check_out"
                       class="form-control @error('new_check_out') is-invalid @enderror"
                       value="{{ old('new_check_out', $booking->check_out->format('Y-m-d')) }}"
                       min="{{ now()->addDay()->format('Y-m-d') }}">
                @error('new_check_out')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        @if($booking->cancellation_policy)
        <div class="alert alert-warning small mb-4">
            <i class="bi bi-exclamation-triangle me-1"></i>
            <strong>Cancellation Policy:</strong> {{ $booking->cancellation_policy }}
        </div>
        @endif

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"
                    onclick="return confirm('Are you sure you want to reschedule this booking?');">
                <i class="bi bi-check-circle me-1"></i> Confirm Reschedule
            </button>
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
