@extends('layouts.dashboard')
@section('page-title', 'Edit Profile')

@section('dashboard-content')
    <div class="profile-content-card">
        <h4 class="fw-bold mb-4">Edit Profile</h4>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
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

            <!-- Avatar Upload -->
            <div class="text-center mb-4">
                <div class="sidebar-avatar mx-auto mb-2" style="width: 100px; height: 100px;">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" id="avatarPreview">
                    @else
                        <div class="sidebar-avatar-placeholder" id="avatarPlaceholder" style="width: 100px; height: 100px; font-size: 2rem;">
                            {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                        </div>
                        <img src="" alt="Avatar" id="avatarPreview" class="d-none" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                    @endif
                </div>
                <label for="avatarUpload" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-camera me-1"></i> Change Photo
                </label>
                <input type="file" id="avatarUpload" name="avatar" class="d-none" accept="image/*">
            </div>

            <hr>

            <!-- Basic Information -->
            <h6 class="fw-bold mb-3">Basic Information</h6>
            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <label for="first_name" class="form-label small text-muted">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                           value="{{ old('first_name', $user->first_name) }}" required>
                </div>
                <div class="col-sm-6">
                    <label for="last_name" class="form-label small text-muted">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                           value="{{ old('last_name', $user->last_name) }}" required>
                </div>
                <div class="col-sm-6">
                    <label for="date_of_birth" class="form-label small text-muted">Date of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                           value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
                </div>
                <div class="col-sm-6">
                    <label for="gender" class="form-label small text-muted">Gender</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="">Select gender</option>
                        <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $user->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="bio" class="form-label small text-muted">Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3"
                              placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                </div>
            </div>

            <!-- Contact Information -->
            <h6 class="fw-bold mb-3">Contact Information</h6>
            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <label for="phone" class="form-label small text-muted">Mobile Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone"
                           value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="col-sm-6">
                    <label for="email" class="form-label small text-muted">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                    <small class="text-muted">Email cannot be changed here</small>
                </div>
                <div class="col-sm-6">
                    <label for="emergency_contact" class="form-label small text-muted">Emergency Contact</label>
                    <input type="text" class="form-control" id="emergency_contact" name="emergency_contact"
                           value="{{ old('emergency_contact', $user->emergency_contact) }}">
                </div>
                <div class="col-sm-6">
                    <label for="address" class="form-label small text-muted">Address</label>
                    <input type="text" class="form-control" id="address" name="address"
                           value="{{ old('address', $user->address) }}">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom text-white px-4">Save Changes</button>
                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('avatarUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                const placeholder = document.getElementById('avatarPlaceholder');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
