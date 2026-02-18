@extends('layouts.dashboard')
@section('page-title', 'Profile')

@section('dashboard-content')
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
