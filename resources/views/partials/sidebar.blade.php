<div class="sidebar-card">
    <!-- User Info -->
    <div class="sidebar-user text-center">
        <div class="sidebar-avatar mx-auto mb-3">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
            @else
                <div class="sidebar-avatar-placeholder">
                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                </div>
            @endif
            <label for="avatarUpload" class="avatar-camera-btn">
                <i class="bi bi-camera-fill"></i>
            </label>
        </div>
        <h6 class="fw-bold mb-0">Hi, {{ Auth::user()->full_name }}</h6>
        <small class="text-muted">{{ Auth::user()->email }}</small>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav mt-4">
        <a href="{{ route('profile.show') }}"
           class="sidebar-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </div>
            <i class="bi bi-chevron-right"></i>
        </a>

        <a href="#" class="sidebar-nav-item {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-heart"></i>
                <span>Your Wishlist</span>
            </div>
            <i class="bi bi-chevron-right"></i>
        </a>

        <a href="#" class="sidebar-nav-item {{ request()->routeIs('payment.*') ? 'active' : '' }}">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-credit-card"></i>
                <span>Payment Methods</span>
            </div>
            <i class="bi bi-chevron-right"></i>
        </a>

        <a href="#" class="sidebar-nav-item {{ request()->routeIs('bookings.upcoming') ? 'active' : '' }}">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-calendar-check"></i>
                <span>Upcoming Bookings</span>
            </div>
            <i class="bi bi-chevron-right"></i>
        </a>

        <a href="#" class="sidebar-nav-item {{ request()->routeIs('bookings.previous') ? 'active' : '' }}">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-clock-history"></i>
                <span>Previous Bookings</span>
            </div>
            <i class="bi bi-chevron-right"></i>
        </a>

        <a href="{{ route('settings.index') }}" class="sidebar-nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-gear"></i>
                <span>Security and settings</span>
            </div>
            <i class="bi bi-chevron-right"></i>
        </a>

        <a href="#" class="sidebar-nav-item {{ request()->routeIs('help.*') ? 'active' : '' }}">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-question-circle"></i>
                <span>Help and feedback</span>
            </div>
            <i class="bi bi-chevron-right"></i>
        </a>
    </nav>

    <!-- Logout -->
    <div class="sidebar-logout mt-3 pt-3 border-top">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-nav-item text-danger w-100 border-0 bg-transparent">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Log out</span>
                </div>
            </button>
        </form>
    </div>
</div>
