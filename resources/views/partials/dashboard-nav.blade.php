<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('landing') }}">SolanaTravels</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="dashboardNav">
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <li class="nav-item">
                    <div class="currency-selector">
                        <span class="fw-medium">USD</span>
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 30'%3E%3Crect width='60' height='30' fill='%23012169'/%3E%3Cpath d='M0,0 L60,30 M60,0 L0,30' stroke='%23fff' stroke-width='6'/%3E%3Cpath d='M0,0 L60,30 M60,0 L0,30' stroke='%23C8102E' stroke-width='4'/%3E%3Cpath d='M30,0 V30 M0,15 H60' stroke='%23fff' stroke-width='10'/%3E%3Cpath d='M30,0 V30 M0,15 H60' stroke='%23C8102E' stroke-width='6'/%3E%3C/svg%3E" alt="Flag" class="flag-icon">
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark">Support</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark">Trips</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark">
                        <i class="bi bi-chat-dots"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.show') }}" class="nav-link d-flex align-items-center gap-2 text-dark">
                        <div class="nav-avatar">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                            @else
                                <div class="nav-avatar-placeholder">
                                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="d-none d-lg-block">
                            <small class="text-muted d-block lh-1">Welcome back!</small>
                            <span class="fw-medium lh-1">{{ Auth::user()->full_name }}</span>
                        </div>
                        <i class="bi bi-patch-check-fill text-primary"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
