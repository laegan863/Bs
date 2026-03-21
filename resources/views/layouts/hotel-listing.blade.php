<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolanaTravels - Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/hotel-listing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
</head>
<body class="bg-light">

    {{-- Loader Styles (kept outside so they persist after pageLoader is removed) --}}
    <style>
        @keyframes loaderPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.15); opacity: .7; }
        }
        @keyframes loaderDots {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
        .loader-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #1a237e 0%, #4267B2 100%);
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            animation: loaderPulse 1.6s ease-in-out infinite;
            box-shadow: 0 8px 32px rgba(26, 35, 126, 0.25);
        }
        .loader-icon i { font-size: 1.8rem; color: #fff; }
        .loader-text {
            font-family: 'Inter', sans-serif;
            font-weight: 600; font-size: 1rem;
            color: #1a237e;
            letter-spacing: .3px;
        }
        .loader-dots { display: flex; gap: 6px; }
        .loader-dots span {
            width: 8px; height: 8px;
            background: #1a237e;
            border-radius: 50%;
            animation: loaderDots 1.2s infinite ease-in-out;
        }
        .loader-dots span:nth-child(2) { animation-delay: .15s; }
        .loader-dots span:nth-child(3) { animation-delay: .3s; }
        .loader-sub {
            font-family: 'Inter', sans-serif;
            font-size: .82rem; color: #94a3b8;
        }
    </style>

    {{-- Fullscreen Loading Overlay --}}
    <div id="pageLoader" style="position:fixed;inset:0;z-index:9999;background:rgba(255,255,255,0.97);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1.5rem;transition:opacity .4s ease;">
        <div class="loader-icon"><i class="bi bi-building"></i></div>
        <div class="loader-text">Finding the best hotels for you</div>
        <div class="loader-dots"><span></span><span></span><span></span></div>
        <div class="loader-sub">Searching across 1,800,000+ properties worldwide</div>
    </div>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top" style="z-index: 1030;">
        <div class="container-fluid px-lg-5">
            <a class="navbar-brand fw-bold" href="{{ route('landing') }}" style="color: var(--primary-navy);">SolanaTravels</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#listingNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="listingNav">
                {{-- Right Nav --}}
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <div class="currency-selector">
                            <span class="fw-medium">USD</span>
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 30'%3E%3Crect width='60' height='30' fill='%23012169'/%3E%3Cpath d='M0,0 L60,30 M60,0 L0,30' stroke='%23fff' stroke-width='6'/%3E%3Cpath d='M0,0 L60,30 M60,0 L0,30' stroke='%23C8102E' stroke-width='4'/%3E%3Cpath d='M30,0 V30 M0,15 H60' stroke='%23fff' stroke-width='10'/%3E%3Cpath d='M30,0 V30 M0,15 H60' stroke='%23C8102E' stroke-width='6'/%3E%3C/svg%3E" alt="Flag" class="flag-icon">
                        </div>
                    </li>
                    <li class="nav-item"><a href="{{ route('support') }}" class="nav-link text-dark">Support</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark">Trips</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark"><i class="bi bi-chat-dots"></i></a></li>
                    @if(!Auth::user())
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link text-dark fw-medium">Sign in</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('profile.show') }}" class="nav-link d-flex align-items-center gap-2 text-dark">
                            <div class="nav-avatar">
                                @if(Auth::user()->avatar && file_exists(public_path('storage/' . Auth::user()->avatar)))
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
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- Search Bar Strip --}}
    <div class="listing-search-strip">
        <div class="container-fluid px-lg-5 py-2">
            <form method="GET" action="{{ route('search') }}" class="listing-search-form d-flex align-items-center" id="listingSearchForm">
                <div class="listing-search-field" style="position: relative; flex: 1;">
                    <i class="bi bi-search"></i>
                    <input type="text" id="inlineSearchInput" autocomplete="off" class="form-control form-control-sm border-0 shadow-none" placeholder="Search for Properties or Places">
                    <input type="hidden" name="property" id="inlinePropertyId" value="{{ $property ?? '' }}">
                    <div id="inlineCityDropdown" class="city-search-dropdown" style="display: none; position: absolute; top: 100%; left: 0; z-index: 1060; min-width: 280px;">
                        <div id="inlineCityLoading" class="p-2 text-center" style="display: none;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                            <span class="ms-2 small text-muted">Searching...</span>
                        </div>
                        <div id="inlineCityResults"></div>
                    </div>
                </div>
                <div class="listing-search-field" id="inlineCheckinField" style="cursor: pointer;">
                    <i class="bi bi-calendar-event"></i>
                    <div>
                        <span class="small fw-bold d-block lh-sm" id="inlineCheckinDisplay">{{ \Carbon\Carbon::parse($checkin ?? now())->format('d M Y') }}</span>
                        <small class="text-muted" style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($checkin ?? now())->format('l') }}</small>
                    </div>
                    <input type="hidden" name="checkin" id="inlineCheckinVal" value="{{ $checkin ?? now()->format('Y-m-d') }}">
                </div>
                <div class="listing-search-field" onclick="$('#inlineCheckinField').click();" style="cursor: pointer;">
                    <i class="bi bi-calendar-event"></i>
                    <div>
                        <span class="small fw-bold d-block lh-sm" id="inlineCheckoutDisplay">{{ \Carbon\Carbon::parse($checkout ?? now()->addDay())->format('d M Y') }}</span>
                        <small class="text-muted" style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($checkout ?? now()->addDay())->format('l') }}</small>
                    </div>
                    <input type="hidden" name="checkout" id="inlineCheckoutVal" value="{{ $checkout ?? now()->addDay()->format('Y-m-d') }}">
                </div>
                <div class="listing-search-field">
                    <i class="bi bi-people-fill"></i>
                    <div>
                        <span class="small fw-bold d-block lh-sm">{{ $adults ?? 2 }} Adults - {{ $children ?? 0 }} Child</span>
                        <small class="text-muted" style="font-size: 0.7rem;">{{ $rooms ?? 1 }} Room</small>
                    </div>
                </div>
                <input type="hidden" name="adults" value="{{ $adults ?? 2 }}">
                <input type="hidden" name="children" value="{{ $children ?? 0 }}">
                <input type="hidden" name="rooms" value="{{ $rooms ?? 1 }}">
                <button type="submit" class="btn listing-search-btn ms-auto">
                    <i class="bi bi-search me-1"></i> Search
                </button>
            </form>
        </div>
    </div>

    @yield('content')

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- Inline DateRangePicker --}}
    <script>
    $(function() {
        $('#inlineCheckinField').daterangepicker({
            startDate: moment('{{ $checkin ?? now()->format("Y-m-d") }}'),
            endDate: moment('{{ $checkout ?? now()->addDay()->format("Y-m-d") }}'),
            minDate: moment(),
            opens: 'center',
            locale: { format: 'DD MMM YYYY' }
        }, function(start, end) {
            $('#inlineCheckinDisplay').text(start.format('DD MMM YYYY'));
            $('#inlineCheckoutDisplay').text(end.format('DD MMM YYYY'));
            $('#inlineCheckinVal').val(start.format('YYYY-MM-DD'));
            $('#inlineCheckoutVal').val(end.format('YYYY-MM-DD'));
        });

        // Inline city search
        (function() {
            const input = document.getElementById('inlineSearchInput');
            const dropdown = document.getElementById('inlineCityDropdown');
            const loading = document.getElementById('inlineCityLoading');
            const results = document.getElementById('inlineCityResults');
            const hiddenId = document.getElementById('inlinePropertyId');
            let debounceTimer;

            input.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const q = this.value.trim();
                if (q.length < 2) { dropdown.style.display = 'none'; return; }
                debounceTimer = setTimeout(() => {
                    dropdown.style.display = 'block';
                    loading.style.display = 'block';
                    results.innerHTML = '';
                    fetch(`{{ route('search.cities') }}?q=${encodeURIComponent(q)}`)
                        .then(r => r.json())
                        .then(cities => {
                            loading.style.display = 'none';
                            if (!cities.length) {
                                results.innerHTML = '<div class="p-2 text-muted small text-center">No cities found</div>';
                                return;
                            }
                            results.innerHTML = cities.map(c =>
                                `<div class="city-search-item" data-id="${c.city_id}" style="padding: 8px 12px; cursor: pointer;">
                                    <i class="bi bi-geo-alt me-2 text-muted"></i>${c.city_name || ''} <small class="text-muted">${c.country_name || ''}</small>
                                </div>`
                            ).join('');
                            results.querySelectorAll('.city-search-item').forEach(item => {
                                item.addEventListener('click', () => {
                                    input.value = item.textContent.trim();
                                    hiddenId.value = item.dataset.id;
                                    dropdown.style.display = 'none';
                                });
                                item.addEventListener('mouseenter', () => item.style.background = '#f0f0f0');
                                item.addEventListener('mouseleave', () => item.style.background = '');
                            });
                        });
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        })();
    });
    </script>

    @yield('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var loader = document.getElementById('pageLoader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(function() { loader.remove(); }, 400);
        }

        // Show loader on search form submit
        var searchForm = document.getElementById('listingSearchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var pageLoader = document.getElementById('pageLoader');
                if (!pageLoader) {
                    // Recreate the loader since pageLoader was removed after initial load
                    pageLoader = document.createElement('div');
                    pageLoader.id = 'searchLoader';
                    pageLoader.style.cssText = 'position:fixed;inset:0;z-index:9999;background:rgba(255,255,255,0.97);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1.5rem;';
                    pageLoader.innerHTML = '<div class="loader-icon"><i class="bi bi-building"></i></div>'
                        + '<div class="loader-text">Finding the best hotels for you</div>'
                        + '<div class="loader-dots"><span></span><span></span><span></span></div>'
                        + '<div class="loader-sub">Searching across 1,800,000+ properties worldwide</div>';
                    document.body.appendChild(pageLoader);
                } else {
                    pageLoader.style.opacity = '1';
                    pageLoader.style.display = 'flex';
                }
                var self = this;
                setTimeout(function() { self.submit(); }, 50);
            });
        }
    });
    </script>
</body>
</html>
