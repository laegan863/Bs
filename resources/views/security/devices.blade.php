@extends('layouts.dashboard')
@section('page-title', 'Connected Devices')

@section('dashboard-content')
    <div class="profile-content-card">
        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">Connected devices</h4>
        </div>

        <p class="text-muted small mb-1">
            Your account is currently signed into <strong>{{ $deviceCount }} {{ Str::plural('device', $deviceCount) }}</strong> on SolanaTravels
        </p>
        <p class="text-muted small mb-4">You're signed into SolanaTravels</p>

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
                                {{ $device['browser'] }}
                            </div>
                            <div class="small text-muted mt-1">
                                {{ $device['last_active_date'] }}
                            </div>
                        </div>
                        @if(!$device['current'])
                            <form method="POST" action="{{ route('settings.session.destroy', $device['id']) }}"
                                  onsubmit="return confirm('Sign out this device?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-primary fw-semibold p-0 text-decoration-none">Sign out</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
