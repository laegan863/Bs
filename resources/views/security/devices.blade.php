@extends('layouts.dashboard')
@section('page-title', 'Connected Devices')

@section('dashboard-content')
    <div class="profile-content-card">
        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">Connected Devices</h4>
        </div>

        <p class="text-muted small mb-4">These are the devices currently logged in to your account. If you don't recognize a device, sign out of it immediately.</p>

        <div class="devices-list">
            @foreach($devices as $device)
                <div class="device-item {{ $device['current'] ? 'device-current' : '' }}">
                    <div class="d-flex align-items-start gap-3">
                        <div class="device-icon">
                            <i class="bi {{ $device['icon'] }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold">{{ $device['name'] }}</span>
                                @if($device['current'])
                                    <span class="badge bg-success-subtle text-success small">This device</span>
                                @endif
                            </div>
                            <div class="small text-muted mt-1">
                                <span>{{ $device['location'] }}</span>
                                <span class="mx-1">&middot;</span>
                                <span>IP: {{ $device['ip'] }}</span>
                            </div>
                            <div class="small {{ $device['current'] ? 'text-success' : 'text-muted' }} mt-1">
                                {{ $device['last_active'] }}
                            </div>
                        </div>
                        @if(!$device['current'])
                            <button class="btn btn-primary-custom text-white btn-sm">Sign out</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
