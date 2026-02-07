@extends('layouts.index')
@section('content')
    @include('partials.login-nav')

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row g-4">
            <!-- Left Column - Hero Image -->
            <div class="col-lg-7">
                <div class="hero-image">
                    <img src="{{ asset('assets/images/login-1.jpg') }}" alt="Luxury Resort Pool">
                </div>
            </div>

            <!-- Right Column - Login Form -->
            <div class="col-lg-5">
                <!-- Benefits Card -->
                <div class="benefits-card">
                    <h6 class="fw-bold mb-3">LOG IN TO</h6>
                    <div class="benefit-item">
                        <i class="bi bi-currency-bitcoin benefit-icon crypto"></i>
                        <span class="small">Access 100+ crypto payment options</span>
                    </div>
                    <div class="benefit-item">
                        <i class="bi bi-arrow-repeat benefit-icon rewards"></i>
                        <span class="small">Get up to 10% back in rewards</span>
                    </div>
                    <div class="benefit-item">
                        <i class="bi bi-gem benefit-icon crown"></i>
                        <span class="small">See exclusive member pricing</span>
                    </div>
                </div>

                <!-- Login Card -->
                <div class="login-card">
                    <h4 class="fw-bold mb-2">Sign up</h4>
                    <p class="text-muted small mb-4">Create your new account</p>
                    @include('partials.login-card')

                    <div class="text-center text-muted small my-3">or log in with</div>

                    <!-- Login Form -->
                    <form>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" placeholder="John">
                            </div>
                            <div class="col-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" placeholder="Smith">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="signupEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="signupEmail" placeholder="johndoe123@gmail.com">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Mobile number</label>
                            <div class="phone-input-wrapper">
                                <input type="tel" class="form-control" id="phone" placeholder="1234567891">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="signupPassword" class="form-label">Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="signupPassword" placeholder="••••••••••">
                                <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('signupPassword', this)"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 text-white mb-3">Sign up</button>
                        <p class="text-center small mb-0">
                            Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-medium" onclick="togglePage('login')">Log in</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/main.js') }}"></script>
@endPush
