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
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-cancel-booking"
                                                data-booking-id="{{ $booking->id }}"
                                                data-booking-name="{{ $booking->property_name }}"
                                                data-cancel-url="{{ route('bookings.cancel', $booking) }}"
                                                data-summary-url="{{ route('bookings.cancellation.summary', $booking) }}"
                                                data-refund-amount="{{ $booking->total_price }}"
                                                data-currency="{{ $booking->currency }}">
                                                <i class="bi bi-x-circle me-1"></i> Cancel Booking
                                            </button>
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

<!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="cancelBookingModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>Cancel Booking
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Initial Confirmation State -->
                <div id="cancelConfirmState">
                    <p class="mb-2">Are you sure you want to cancel your booking at:</p>
                    <p class="fw-bold mb-3" id="cancelBookingName"></p>
                    <div id="cancelSummaryLoading" class="text-center py-3 d-none">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                        <span class="text-muted small">Fetching cancellation details...</span>
                    </div>
                    <div id="cancelSummaryContent" class="d-none">
                        <div class="p-3 rounded-3 mb-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
                            <small class="text-muted d-block mb-2 fw-semibold">Cancellation Summary</small>
                            <div id="cancelSummaryDetails"></div>
                        </div>
                    </div>
                    <div class="alert alert-warning small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        This action cannot be undone. If eligible, a travel credit will be issued.
                    </div>
                </div>

                <!-- Processing State -->
                <div id="cancelProcessingState" class="text-center py-4 d-none">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <p class="text-muted mb-0">Cancelling your booking, please wait...</p>
                </div>

                <!-- Result State -->
                <div id="cancelResultState" class="d-none">
                    <div class="text-center py-3">
                        <div id="cancelResultIcon" class="mb-3"></div>
                        <h5 id="cancelResultTitle" class="fw-bold mb-2"></h5>
                        <div id="cancelResultMessage" class="mb-3"></div>
                        <div id="cancelCreditInfo" class="d-none p-3 rounded-3 mx-auto" style="background:#e8f5e9; border:1px solid #a5d6a7; max-width:350px;">
                            <i class="bi bi-wallet2 text-success me-1"></i>
                            <span class="small fw-medium text-success" id="cancelCreditText"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="cancelModalFooter">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="cancelCloseBtn">Close</button>
                <button type="button" class="btn btn-danger btn-sm" id="cancelConfirmBtn">
                    <i class="bi bi-x-circle me-1"></i> Yes, Cancel Booking
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let cancelModal = null;
    let currentCancelUrl = '';
    let currentRefundAmount = 0;
    let currentCurrency = 'USD';

    document.querySelectorAll('.btn-cancel-booking').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = this.dataset;
            currentCancelUrl = data.cancelUrl;
            currentRefundAmount = parseFloat(data.refundAmount || 0);
            currentCurrency = data.currency || 'USD';

            // Reset modal to confirm state
            document.getElementById('cancelConfirmState').classList.remove('d-none');
            document.getElementById('cancelProcessingState').classList.add('d-none');
            document.getElementById('cancelResultState').classList.add('d-none');
            document.getElementById('cancelConfirmBtn').classList.remove('d-none');
            document.getElementById('cancelConfirmBtn').disabled = false;
            document.getElementById('cancelBookingName').textContent = data.bookingName;
            document.getElementById('cancelSummaryLoading').classList.add('d-none');
            document.getElementById('cancelSummaryContent').classList.add('d-none');

            cancelModal = new bootstrap.Modal(document.getElementById('cancelBookingModal'));
            cancelModal.show();

            // Fetch cancellation summary
            if (data.summaryUrl) {
                document.getElementById('cancelSummaryLoading').classList.remove('d-none');
                fetch(data.summaryUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(r => r.json())
                .then(result => {
                    document.getElementById('cancelSummaryLoading').classList.add('d-none');
                    if (result.success && result.data) {
                        const d = result.data;
                        let html = '';
                        if (d.cancellationCharges !== undefined) {
                            html += '<div class="d-flex justify-content-between mb-1"><span class="small text-muted">Cancellation charges</span><span class="small fw-medium">' + currentCurrency + ' ' + parseFloat(d.cancellationCharges || 0).toFixed(2) + '</span></div>';
                        }
                        if (d.refundRate) {
                            html += '<div class="d-flex justify-content-between mb-1"><span class="small text-muted">Refund amount</span><span class="small fw-medium text-success">' + (d.refundRate.currency || currentCurrency) + ' ' + parseFloat(d.refundRate.inclusive || 0).toFixed(2) + '</span></div>';
                            currentRefundAmount = parseFloat(d.refundRate.inclusive || 0);
                            currentCurrency = d.refundRate.currency || currentCurrency;
                        }
                        if (d.status) {
                            html += '<div class="d-flex justify-content-between mb-1"><span class="small text-muted">Status</span><span class="small fw-medium">' + d.status + '</span></div>';
                        }
                        if (!html && d.errorMessage) {
                            html = '<p class="small text-danger mb-0">' + (d.errorMessage.message || 'Could not retrieve summary.') + '</p>';
                        }
                        if (html) {
                            document.getElementById('cancelSummaryDetails').innerHTML = html;
                            document.getElementById('cancelSummaryContent').classList.remove('d-none');
                        }
                    }
                })
                .catch(() => {
                    document.getElementById('cancelSummaryLoading').classList.add('d-none');
                });
            }
        });
    });

    document.getElementById('cancelConfirmBtn').addEventListener('click', function() {
        // Switch to processing state
        document.getElementById('cancelConfirmState').classList.add('d-none');
        document.getElementById('cancelProcessingState').classList.remove('d-none');
        this.classList.add('d-none');

        fetch(currentCancelUrl, {
            method: 'PATCH',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                refund_amount: currentRefundAmount,
                currency: currentCurrency,
            })
        })
        .then(r => r.json())
        .then(result => {
            document.getElementById('cancelProcessingState').classList.add('d-none');
            document.getElementById('cancelResultState').classList.remove('d-none');

            const iconEl = document.getElementById('cancelResultIcon');
            const titleEl = document.getElementById('cancelResultTitle');
            const msgEl = document.getElementById('cancelResultMessage');
            const creditEl = document.getElementById('cancelCreditInfo');

            if (result.success) {
                iconEl.innerHTML = '<div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width:64px;height:64px;background:#e8f5e9;"><i class="bi bi-check-circle-fill text-success" style="font-size:2rem;"></i></div>';
                titleEl.textContent = 'Booking Cancelled';
                titleEl.style.color = '#16a34a';
                msgEl.innerHTML = '<p class="text-muted small mb-0">' + (result.message || 'Your booking has been cancelled successfully.') + '</p>';

                if (result.credit_awarded && result.credit_amount > 0) {
                    creditEl.classList.remove('d-none');
                    document.getElementById('cancelCreditText').textContent = result.currency + ' ' + parseFloat(result.credit_amount).toFixed(2) + ' travel credit has been added to your account.';
                } else {
                    creditEl.classList.add('d-none');
                }
            } else {
                iconEl.innerHTML = '<div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width:64px;height:64px;background:#fee2e2;"><i class="bi bi-x-circle-fill text-danger" style="font-size:2rem;"></i></div>';
                titleEl.textContent = 'Cancellation Failed';
                titleEl.style.color = '#dc2626';
                msgEl.innerHTML = '<p class="text-muted small mb-0">' + (result.error || 'Something went wrong. Please try again.') + '</p>';
                creditEl.classList.add('d-none');
            }
        })
        .catch(err => {
            document.getElementById('cancelProcessingState').classList.add('d-none');
            document.getElementById('cancelResultState').classList.remove('d-none');

            document.getElementById('cancelResultIcon').innerHTML = '<div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width:64px;height:64px;background:#fee2e2;"><i class="bi bi-x-circle-fill text-danger" style="font-size:2rem;"></i></div>';
            document.getElementById('cancelResultTitle').textContent = 'Error';
            document.getElementById('cancelResultTitle').style.color = '#dc2626';
            document.getElementById('cancelResultMessage').innerHTML = '<p class="text-muted small mb-0">Network error. Please check your connection and try again.</p>';
            document.getElementById('cancelCreditInfo').classList.add('d-none');
        });
    });

    // Reload page when modal is closed after a result (to update booking status)
    document.getElementById('cancelBookingModal').addEventListener('hidden.bs.modal', function() {
        if (!document.getElementById('cancelResultState').classList.contains('d-none')) {
            window.location.reload();
        }
    });
});
</script>
@endpush
@endsection
