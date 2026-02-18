@extends('layouts.dashboard')
@section('page-title', 'Update Mobile')

@section('dashboard-content')
    <div class="profile-content-card">
        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">Update Mobile Number</h4>
        </div>

        <form method="POST" action="{{ route('settings.mobile.update') }}">
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
                <label for="phone" class="form-label small text-muted">New Mobile Number</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
            </div>

            <div class="mb-4">
                <label for="current_password" class="form-label small text-muted">Current Password</label>
                <div class="position-relative">
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                           id="current_password" name="current_password" placeholder="Enter your password to confirm" required>
                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor:pointer;" data-target="current_password"></i>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom text-white px-4">Update Mobile</button>
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
