@extends('layouts.dashboard')
@section('page-title', 'Change Password')

@section('dashboard-content')
    <div class="profile-content-card">
        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">Change Password</h4>
        </div>

        <form method="POST" action="{{ route('settings.password.update') }}">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="alert alert-danger py-2 small">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="current_password" class="form-label small text-muted">Current Password</label>
                <div class="position-relative">
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                           id="current_password" name="current_password" placeholder="Enter current password" required>
                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor:pointer;" data-target="current_password"></i>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label small text-muted">New Password</label>
                <div class="position-relative">
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" placeholder="Enter new password" required>
                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor:pointer;" data-target="password"></i>
                </div>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label small text-muted">Confirm New Password</label>
                <div class="position-relative">
                    <input type="password" class="form-control"
                           id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor:pointer;" data-target="password_confirmation"></i>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom text-white px-4">Change Password</button>
                <a href="{{ route('settings.index') }}" class="btn btn-primary-custom text-white px-4">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(function(el) {
        el.addEventListener('click', function() {
            const input = document.getElementById(this.dataset.target);
            if (input.type === 'password') { input.type = 'text'; this.classList.replace('bi-eye', 'bi-eye-slash'); }
            else { input.type = 'password'; this.classList.replace('bi-eye-slash', 'bi-eye'); }
        });
    });
</script>
@endpush
