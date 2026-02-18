@extends('layouts.dashboard')
@section('page-title', 'Dashboard')

@section('dashboard-content')
    <div class="profile-content-card">
        <h4 class="fw-bold mb-3">Welcome to SolanaTravels</h4>
        <p class="text-muted">Hello {{ Auth::user()->full_name }}, you are logged in!</p>
        <hr>
        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Phone:</strong> {{ Auth::user()->phone ?? 'Not provided' }}</p>
            </div>
        </div>
        <a href="{{ route('profile.show') }}" class="btn btn-primary-custom text-white mt-3">
            <i class="bi bi-person me-1"></i> View Profile
        </a>
    </div>
@endsection
