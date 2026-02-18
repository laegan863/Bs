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
                    <h4 class="fw-bold mb-2">Log in</h4>
                    <p class="text-muted small mb-4">Log in with your open account</p>

                    @include('partials.login-card')

                    <div class="text-center text-muted small my-3">or log in with</div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-danger py-2 small">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success py-2 small">{{ session('success') }}</div>
                        @endif

                        <div class="mb-3">
                            <label for="email" class="form-label small text-muted">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="eg: johndoe123@gmail.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label small text-muted">Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••••" required>
                                <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;"></i>
                            </div>
                            <div class="text-end mt-2">
                                <a href="#" class="small text-decoration-none">forgot password?</a>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label small" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 text-white mb-3">Log in</button>
                        <p class="text-center small mb-0">
                            Don't have an account. <a href="{{ route('register') }}" class="text-decoration-none fw-medium">Sign up</a>
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
