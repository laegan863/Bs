@extends('layouts.dashboard')
@section('page-title', 'Profile')

@section('dashboard-content')
    {{-- Credit Balance Section --}}
    @php
        $creditBalance = $user->creditBalance();
        $creditHistory = $user->credits()->with('booking')->latest()->take(5)->get();
    @endphp
    <div id="credit" class="profile-content-card mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:40px; height:40px; background: linear-gradient(135deg,#a5d6a7,#66bb6a);">
                    <i class="bi bi-wallet2 text-white"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Travel Credit</h6>
                    <small class="text-muted">Earned from cancelled online bookings</small>
                </div>
            </div>
            <div class="text-end">
                <div class="fw-bold fs-4 mb-0" style="color:#1b5e20;">
                    USD {{ number_format($creditBalance, 2) }}
                </div>
                <small class="text-muted">Available balance</small>
            </div>
        </div>

        @if($creditHistory->isNotEmpty())
        <hr class="my-3">
        <h6 class="fw-semibold mb-2 text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:.5px;">Recent Activity</h6>
        <div class="d-flex flex-column gap-2">
            @foreach($creditHistory as $credit)
            <div class="d-flex justify-content-between align-items-center p-2 rounded-3"
                 style="background:{{ $credit->type === 'earned' ? '#f1f8e9' : '#fff3e0' }};">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi {{ $credit->type === 'earned' ? 'bi-arrow-down-circle-fill text-success' : 'bi-arrow-up-circle-fill text-warning' }}"></i>
                    <div>
                        <span class="small fw-medium">{{ $credit->description ?? ($credit->type === 'earned' ? 'Credit earned' : 'Credit used') }}</span>
                        <span class="d-block text-muted" style="font-size:0.7rem;">{{ $credit->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <span class="fw-bold {{ $credit->type === 'earned' ? 'text-success' : 'text-warning' }}">
                    {{ $credit->type === 'earned' ? '+' : '' }}{{ number_format($credit->amount, 2) }} {{ $credit->currency }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted small mb-0 mt-2">
            <i class="bi bi-info-circle me-1"></i>
            No credit history yet. Credits are earned when you cancel a booking paid online with a refund.
        </p>
        @endif
    </div>

    <div class="profile-content-card">
        <!-- Header -->
        <div class="profile-header d-flex justify-content-between align-items-start">
            <h4 class="fw-bold mb-0">{{ $user->full_name }}</h4>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm rounded-circle">
                <i class="bi bi-pencil-square"></i>
            </a>
        </div>

        <hr class="my-3">

        <!-- Basic Information -->
        <div class="mb-4">
            <h6 class="fw-bold mb-3">Basic Information</h6>
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Name</span>
                        <span class="profile-info-value">{{ $user->full_name }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Bio</span>
                        <span class="profile-info-value">{{ $user->bio ?? 'Not provided' }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Date of birth</span>
                        <span class="profile-info-value">{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not provided' }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Gender</span>
                        <span class="profile-info-value">{{ $user->gender ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div>
            <h6 class="fw-bold mb-3">Contact Information</h6>
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Mobile Number</span>
                        <span class="profile-info-value">{{ $user->phone ?? 'Not provided' }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Email</span>
                        <span class="profile-info-value">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Emergency Contact</span>
                        <span class="profile-info-value">{{ $user->emergency_contact ?? 'Not provided' }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Address</span>
                        <span class="profile-info-value">{{ $user->address ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
