@extends('layouts.dashboard')
@section('page-title', 'Security and Settings')

@section('dashboard-content')
    <div class="profile-content-card">
        <h4 class="fw-bold mb-1">Security and settings</h4>
        <p class="text-muted small mb-4">Keep your account safe with a secure password and by signing out of devices you're not actively using.</p>

        <div class="col-lg-6">
            <!-- Email -->
            <a href="{{ route('settings.email') }}" class="settings-item my-2">
                <div>
                    <span class="settings-item-label">Email</span>
                    <span class="settings-item-value">{{ $user->email }}</span>
                </div>
                <i class="bi bi-chevron-right"></i>
            </a>

            <!-- Mobile -->
            <a href="{{ route('settings.mobile') }}" class="settings-item my-2">
                <div>
                    <span class="settings-item-label">Mobile</span>
                    <span class="settings-item-value">{{ $user->phone ?? 'Not provided' }}</span>
                </div>
                <i class="bi bi-chevron-right"></i>
            </a>

            <!-- Change Password -->
            <a href="{{ route('settings.password') }}" class="settings-item my-2">
                <div>
                    <span class="settings-item-label">Change Password</span>
                </div>
                <i class="bi bi-chevron-right"></i>
            </a>

            <!-- Connected Devices -->
            <a href="{{ route('settings.devices') }}" class="settings-item my-2">
                <div>
                    <span class="settings-item-label">Connected Devices</span>
                </div>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
@endsection
