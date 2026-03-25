<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolanaTravels - Book Hotels with Crypto & Save Up to 75%</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/property.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
</head>
<body>

    <!-- ============================
         Top Promo Banner
         ============================ -->
    <div class="promo-banner">
        <div class="container d-flex align-items-center justify-content-center gap-3 py-2">
            <span class="small fw-medium text-white">GET UP TO 15% BACK IN TRAVEL CREDITS WITH</span>
            <span class="badge bg-white text-dark fw-bold px-2 py-1 d-flex align-items-center gap-1">
                <i class="bi bi-wallet2"></i> Pay
            </span>
            <a href="#" class="text-white small text-decoration-underline">T&C</a>
            <a href="#" class="btn btn-outline-light btn-sm px-3 py-1 fw-semibold">BOOK NOW</a>
            <button class="btn-close btn-close-white ms-2 small" aria-label="Close" onclick="this.closest('.promo-banner').remove()"></button>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">SolanaTravels</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="landingNav">
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

    <!-- ============================
         Hero Section
         ============================ -->
    <section class="hero-section" style="background: url('{{ asset('banner.jpeg') }}') center/cover no-repeat; position: relative;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="text-center py-4 py-md-5">
                <h1 class="fw-bold mb-2 hero-main-title" style="color: #1a1a2e; letter-spacing: 0.5px;">Book Hotels with Crypto. Save Up to 75%</h1>
                <p class="mb-4" style="color: #1a1a2e; font-size: 1.1rem;">Pay with crypto at 1,800,000+ hotels worldwide. Best prices guaranteed</p>
            </div>

            <!-- Search Bar -->
            <div class="hero-search-bar">
                <form method="GET" action="{{ route('search') }}" class="row g-2 g-lg-0 align-items-center">
                    <div class="col-12 col-lg-3">
                        <div class="search-field" style="position: relative;">
                            <div class="search-field-icon"><i class="bi bi-geo-alt-fill"></i></div>
                            <div class="flex-grow-1">
                                <span class="search-field-label">DESTINATION</span>
                                <input type="text" id="citySearchInput" autocomplete="off" class="form-control border-0 p-0 shadow-none search-field-input" placeholder="Where are you going?">
                                <input type="hidden" name="property" id="cityIdInput" value="">
                            </div>
                            <div id="cityDropdown" class="city-search-dropdown" style="display: none;">
                                <div id="cityDropdownLoading" class="city-search-loading" style="display: none;">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                    <span class="ms-2 small text-muted">Searching cities...</span>
                                </div>
                                <div id="cityDropdownResults"></div>
                                <div id="cityDropdownEmpty" class="city-search-empty" style="display: none;">
                                    <i class="bi bi-search me-1"></i> No cities found
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="search-field search-field-border" id="checkinField" style="cursor: pointer;">
                            <div class="search-field-icon">
                                <img src="{{ asset('calendar.png') }}" height="20px" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <span class="search-field-label">CHECK-IN</span>
                                <span class="fw-bold small d-block" id="checkinDisplay">{{ now()->format('d M Y') }}</span>
                                <input type="hidden" name="checkin" value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="search-field search-field-border" onclick="$('#checkinField').click();" style="cursor: pointer;">
                            <div class="search-field-icon">
                                <img src="{{ asset('calendar.png') }}" height="20px"  alt="">
                            </div>
                            <div class="flex-grow-1">
                                <span class="search-field-label">CHECK-OUT</span>
                                <span class="fw-bold small d-block" id="checkoutDisplay">{{ now()->addDay()->format('d M Y') }}</span>
                                <input type="hidden" name="checkout" value="{{ now()->addDay()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="search-field search-field-border" style="cursor: pointer; position: relative;">
                            <div class="search-field-icon"><i class="bi bi-people"></i></div>
                            <div class="flex-grow-1" id="guestDropdownToggle" style="cursor: pointer;">
                                <span class="search-field-label">GUESTS & ROOMS</span>
                                <span class="fw-bold small" id="guestDisplayBold">2 Adults</span>
                                <small class="text-muted" id="guestDisplaySmall"> &middot; 0 Children &middot; 1 Room</small>
                            </div>
                            <div class="dropdown-menu p-3 show" id="guestDropdown" style="min-width: 300px; display: none; position: absolute; top: 100%; left: 0; z-index: 1050;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Adults</span>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="event.stopPropagation(); changeCount('adults', -1)">-</button>
                                        <span id="adultsCount" class="mx-3">2</span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="event.stopPropagation(); changeCount('adults', 1)">+</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Children</span>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="event.stopPropagation(); changeCount('children', -1)">-</button>
                                        <span id="childrenCount" class="mx-3">0</span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="event.stopPropagation(); changeCount('children', 1)">+</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Rooms</span>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="event.stopPropagation(); changeCount('rooms', -1)">-</button>
                                        <span id="roomsCount" class="mx-3">1</span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="event.stopPropagation(); changeCount('rooms', 1)">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="adults" value="2">
                    <input type="hidden" name="children" value="0">
                    <input type="hidden" name="rooms" value="1">
                    <div class="col-12 col-lg-2 text-end pe-2">
                        <button type="submit" class="btn hero-search-btn">
                            <i class="bi bi-search me-1"></i> SEARCH
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @yield('content')

    <!-- ============================
         Explore Popular Destinations
         ============================ -->
    <section class="explore-section py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle">Explore</span>
                <h2 class="fw-bold mb-2">Explore stays in popular destinations</h2>
                <p class="text-muted">Handpicked hotels with the best prices this month</p>
            </div>

            <!-- Destination Tabs -->
            <ul class="nav nav-pills destination-tabs justify-content-center mb-4" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#beach"><i class="bi bi-sun me-1"></i> Beach</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#culture"><i class="bi bi-bank me-1"></i> Culture</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#ski"><i class="bi bi-snow me-1"></i> Ski</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#family"><i class="bi bi-people me-1"></i> Family</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#wellness"><i class="bi bi-heart-pulse me-1"></i> Wellness</a></li>
            </ul>

            <!-- City Cards Carousel -->
            {{-- @php
                $cities = [
                    ['name' => 'Barcelona', 'country' => 'Spain', 'price' => 189, 'rating' => 4.9, 'reviews' => 2341, 'tag' => 'Popular', 'tagClass' => 'tag-popular', 'property' => '2256959'],
                    ['name' => 'Rome', 'country' => 'Italy', 'price' => 425, 'rating' => 4.8, 'reviews' => 1879, 'tag' => 'Best Deal', 'tagClass' => 'tag-deal', 'property' => '2256959'],
                    ['name' => 'New York', 'country' => 'United States', 'price' => 156, 'rating' => 4.7, 'reviews' => 3102, 'tag' => 'Trending', 'tagClass' => 'tag-trending', 'property' => '2256959'],
                    ['name' => 'Singapore', 'country' => 'Singapore', 'price' => 210, 'rating' => 4.6, 'reviews' => 1456, 'tag' => '', 'tagClass' => '', 'property' => '2256959'],
                    ['name' => 'Paris', 'country' => 'France', 'price' => 340, 'rating' => 4.9, 'reviews' => 987, 'tag' => 'Luxury', 'tagClass' => 'tag-luxury', 'property' => '2256959'],
                    ['name' => 'Tokyo', 'country' => 'Japan', 'price' => 120, 'rating' => 4.5, 'reviews' => 2678, 'tag' => 'Best Deal', 'tagClass' => 'tag-deal', 'property' => '2256959'],
                ];
            @endphp
            <div class="tab-content">
                <div class="tab-pane fade show active" id="beach">
                    <div class="position-relative">
                        <div class="hotel-carousel" id="hotelCarousel">
                            @foreach($cities as $city)
                            <a href="{{ route('search', ['property' => $city['property'], 'checkin' => now()->format('Y-m-d'), 'checkout' => now()->addDay()->format('Y-m-d'), 'adults' => 2, 'children' => 0, 'rooms' => 1]) }}" class="hotel-card text-decoration-none text-dark">
                                <div class="hotel-card-img">
                                    <img src="{{ asset('assets/images/login-1.jpg') }}" alt="{{ $city['name'] }}">
                                    <span class="hotel-card-fav"><i class="bi bi-heart"></i></span>
                                    @if($city['tag'])
                                    <span class="hotel-card-tag {{ $city['tagClass'] }}">{{ $city['tag'] }}</span>
                                    @endif
                                </div>
                                <div class="hotel-card-body">
                                    <div class="d-flex align-items-center gap-1 mb-1">
                                        <span class="hotel-card-rating"><i class="bi bi-star-fill"></i> {{ $city['rating'] }}</span>
                                        <small class="text-muted">({{ number_format($city['reviews']) }})</small>
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ $city['name'] }}</h6>
                                    <p class="small text-muted mb-2"><i class="bi bi-geo-alt-fill me-1"></i>{{ $city['country'] }}</p>
                                    <div class="d-flex align-items-baseline gap-1">
                                        <span class="hotel-card-price">${{ $city['price'] }}</span>
                                        <small class="text-muted">/ night</small>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <button class="carousel-nav-btn carousel-prev" onclick="scrollCarousel('hotelCarousel', -300)">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="carousel-nav-btn carousel-next" onclick="scrollCarousel('hotelCarousel', 300)">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div> --}}

            <!-- Destination Cards Grid -->
            @php
                $destinationsByTab = [
                    'beach' => [
                        ['name' => 'Destin', 'img' => '1.jpg', 'region' => 'Florida, United States of America', 'label' => 'Coastal Bliss', 'property' => '2256959'],
                        ['name' => 'Punta Cana', 'img' => '2.jpg', 'region' => 'La Altagracia, Dominican Republic', 'label' => 'Serene Beaches', 'property' => '2256959'],
                        ['name' => 'Port Aransas', 'img' => '3.webp', 'region' => 'Texas, United States of America', 'label' => 'Relaxed Beaches', 'property' => '2256959'],
                        ['name' => 'Riviera Maya', 'img' => '4.jpg', 'region' => 'Mexico', 'label' => 'Beach Paradise', 'property' => '2256959'],
                    ],
                    'culture' => [
                        ['name' => 'Rome', 'img' => '1.jpg', 'region' => 'Lazio, Italy', 'label' => 'Ancient Wonders', 'property' => '2256959'],
                        ['name' => 'Kyoto', 'img' => '2.jpg', 'region' => 'Kansai, Japan', 'label' => 'Timeless Temples', 'property' => '2256959'],
                        ['name' => 'Istanbul', 'img' => '3.webp', 'region' => 'Turkey', 'label' => 'East Meets West', 'property' => '2256959'],
                        ['name' => 'Marrakech', 'img' => '4.jpg', 'region' => 'Morocco', 'label' => 'Vibrant Souks', 'property' => '2256959'],
                    ],
                    'ski' => [
                        ['name' => 'Zermatt', 'img' => '1.jpg', 'region' => 'Valais, Switzerland', 'label' => 'Alpine Glory', 'property' => '2256959'],
                        ['name' => 'Aspen', 'img' => '2.jpg', 'region' => 'Colorado, United States', 'label' => 'Powder Paradise', 'property' => '2256959'],
                        ['name' => 'Chamonix', 'img' => '3.webp', 'region' => 'Haute-Savoie, France', 'label' => 'Mountain Magic', 'property' => '2256959'],
                        ['name' => 'Niseko', 'img' => '4.jpg', 'region' => 'Hokkaido, Japan', 'label' => 'Snow Heaven', 'property' => '2256959'],
                    ],
                    'family' => [
                        ['name' => 'Orlando', 'img' => '1.jpg', 'region' => 'Florida, United States of America', 'label' => 'Theme Park Fun', 'property' => '2256959'],
                        ['name' => 'Cancun', 'img' => '2.jpg', 'region' => 'Quintana Roo, Mexico', 'label' => 'Family Friendly', 'property' => '2256959'],
                        ['name' => 'Gold Coast', 'img' => '3.webp', 'region' => 'Queensland, Australia', 'label' => 'Endless Fun', 'property' => '2256959'],
                        ['name' => 'Barcelona', 'img' => '4.jpg', 'region' => 'Catalonia, Spain', 'label' => 'City Adventures', 'property' => '2256959'],
                    ],
                    'wellness' => [
                        ['name' => 'Bali', 'img' => '1.jpg', 'region' => 'Indonesia', 'label' => 'Tropical Retreat', 'property' => '2256959'],
                        ['name' => 'Sedona', 'img' => '2.jpg', 'region' => 'Arizona, United States', 'label' => 'Desert Healing', 'property' => '2256959'],
                        ['name' => 'Koh Samui', 'img' => '3.webp', 'region' => 'Surat Thani, Thailand', 'label' => 'Spa Escapes', 'property' => '2256959'],
                        ['name' => 'Tuscany', 'img' => '4.jpg', 'region' => 'Italy', 'label' => 'Wellness Haven', 'property' => '2256959'],
                    ],
                ];
            @endphp
            <div class="tab-content">
                @foreach($destinationsByTab as $tabKey => $destinations)
                <div class="tab-pane fade {{ $tabKey === 'beach' ? 'show active' : '' }}" id="{{ $tabKey }}">
                    <div class="destination-grid mt-4">
                        @foreach($destinations as $dest)
                        <a href="{{ route('search', ['property' => $dest['property'], 'checkin' => now()->format('Y-m-d'), 'checkout' => now()->addDay()->format('Y-m-d'), 'adults' => 2, 'children' => 0, 'rooms' => 1]) }}" class="destination-grid-card text-decoration-none">
                            <div class="destination-grid-img">
                                <img src="{{ asset($dest['img']) }}" alt="{{ $dest['name'] }}">
                                <span class="destination-grid-label">{{ $dest['label'] }}</span>
                            </div>
                            <div class="destination-grid-info">
                                <h6 class="fw-bold mb-0">{{ $dest['name'] }}</h6>
                                <small class="text-muted">{{ $dest['region'] }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary-navy px-4 py-2 fw-medium">View All Destinations <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </section>

    <!-- ============================
         Promotional Banners Slider
         ============================ -->
    <section class="promo-section py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="promo-card h-100">
                    <span class="promo-badge">Featured</span>
                    <h2 class="promo-title">Your ticket to the World Cup</h2>
                    <p class="promo-text">
                        Lock in match seats and build your trip all in one place.
                    </p>
                    <a href="#" class="promo-btn">Get tickets</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="promo-card h-100">
                    <span class="promo-badge">Promotion</span>
                    <h2 class="promo-title">Family favorites: Save up to 40% on stays</h2>
                    <p class="promo-text">
                        Members save up to 40% on select homes the whole family will love.
                        Book by March 16, 2026.
                    </p>
                    <a href="#" class="promo-btn">Book now</a>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- ============================
         Customer Reviews
         ============================ -->
    <section class="reviews-section py-5">
        <div class="container">
            <div class="text-center mb-2">
                <span class="section-subtitle">Customer Reviews</span>
                <h2 class="fw-bold mb-1">Loved by travelers worldwide</h2>
                <p class="text-muted">Real experiences from real guests</p>
            </div>

            <!-- Stats row -->
            <div class="review-stats d-flex justify-content-center gap-4 gap-md-5 mb-5">
                <div class="text-center">
                    <h3 class="fw-bold mb-0" style="color: var(--primary-navy);">50K+</h3>
                    <small class="text-muted">Happy Guests</small>
                </div>
                <div class="review-stats-divider"></div>
                <div class="text-center">
                    <h3 class="fw-bold mb-0" style="color: var(--primary-navy);">4.8</h3>
                    <small class="text-muted"><i class="bi bi-star-fill text-warning"></i> Avg Rating</small>
                </div>
                <div class="review-stats-divider"></div>
                <div class="text-center">
                    <h3 class="fw-bold mb-0" style="color: var(--primary-navy);">120+</h3>
                    <small class="text-muted">Countries</small>
                </div>
            </div>
        </div>

        @php
            $reviews = [
                [
                    'name' => 'Sarah Mitchell',
                    'location' => 'New York, USA',
                    'image' => 'avatars/1.svg',
                    'color' => '#3b82f6',
                    'rating' => 5,
                    'title' => 'Absolutely stunning!',
                    'text' => 'The hotel exceeded all expectations. Rooftop views were breathtaking and the staff went above and beyond. Will definitely book through SolanaTravels again!',
                    'hotel' => 'Santorini Blue Horizon',
                    'time' => '2 weeks ago',
                    'verified' => true,
                ],
                [
                    'name' => 'James Rodriguez',
                    'location' => 'Madrid, Spain',
                    'image' => 'avatars/2.svg',
                    'color' => '#8b5cf6',
                    'rating' => 5,
                    'title' => 'Best crypto booking experience',
                    'text' => 'Paid with SOL and got 15% back in travel credits. The process was seamless and the resort was paradise. Highly recommend for crypto holders!',
                    'hotel' => 'Maldives Paradise Resort',
                    'time' => '1 month ago',
                    'verified' => true,
                ],
                [
                    'name' => 'Emily Chen',
                    'location' => 'Singapore',
                    'image' => 'avatars/3.svg',
                    'color' => '#ec4899',
                    'rating' => 4,
                    'title' => 'Perfect family getaway',
                    'text' => 'Booked a family suite for 5 nights. Kids loved the pool, we loved the spa. Great value for money and the location was unbeatable.',
                    'hotel' => 'Bali Ocean Breeze Villa',
                    'time' => '3 weeks ago',
                    'verified' => true,
                ],
                [
                    'name' => 'Marcus Weber',
                    'location' => 'Berlin, Germany',
                    'image' => 'avatars/4.svg',
                    'color' => '#f59e0b',
                    'rating' => 5,
                    'title' => 'Incredible value!',
                    'text' => 'Saved 40% compared to other platforms. The room was spotless, breakfast was amazing, and checking in was a breeze. 10/10 would recommend.',
                    'hotel' => 'Amalfi Coast Retreat',
                    'time' => '5 days ago',
                    'verified' => true,
                ],
                [
                    'name' => 'Aisha Patel',
                    'location' => 'Mumbai, India',
                    'image' => 'avatars/5.svg',
                    'color' => '#10b981',
                    'rating' => 5,
                    'title' => 'Honeymoon dream come true',
                    'text' => 'Booked our honeymoon suite using USDT. The ocean-view room was magical at sunset. Thank you SolanaTravels for making it so special!',
                    'hotel' => 'Phuket Sunset Resort',
                    'time' => '2 months ago',
                    'verified' => true,
                ],
                [
                    'name' => 'Lucas Ferreira',
                    'location' => 'São Paulo, Brazil',
                    'image' => 'avatars/6.svg',
                    'color' => '#ef4444',
                    'rating' => 5,
                    'title' => 'Smooth and easy',
                    'text' => 'First time using crypto for travel. The platform made everything simple. Hotel was exactly as shown in photos. Great customer support too!',
                    'hotel' => 'Cancún Riviera Suites',
                    'time' => '6 days ago',
                    'verified' => false,
                ],
                [
                    'name' => 'Sophie Laurent',
                    'location' => 'Paris, France',
                    'image' => 'avatars/7.svg',
                    'color' => '#6366f1',
                    'rating' => 5,
                    'title' => 'Magnifique!',
                    'text' => 'Everything was perfect from booking to checkout. The concierge arranged a private boat tour for us. Truly a five-star experience.',
                    'hotel' => 'Santorini Blue Horizon',
                    'time' => '1 week ago',
                    'verified' => true,
                ],
                [
                    'name' => 'Yuki Tanaka',
                    'location' => 'Tokyo, Japan',
                    'image' => 'avatars/8.svg',
                    'color' => '#0ea5e9',
                    'rating' => 4,
                    'title' => 'Great for solo travelers',
                    'text' => 'Clean, comfortable, and well-located. The 24/7 support helped me change my dates last minute. Very impressed with the flexibility.',
                    'hotel' => 'Bali Ocean Breeze Villa',
                    'time' => '3 months ago',
                    'verified' => true,
                ],
            ];
        @endphp

        <!-- Marquee Row 1 (scrolls left) -->
        <div class="review-marquee-wrapper mb-3">
            <div class="review-marquee review-marquee-left">
                <div class="review-marquee-track">
                    @foreach($reviews as $review)
                    <div class="review-card-v2">
                        <div class="review-card-v2-header">
                            <div class="review-avatar">
                                <img src="{{ asset('assets/images/' . $review['image']) }}" alt="{{ $review['name'] }}">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="fw-bold small">{{ $review['name'] }}</span>
                                    @if($review['verified'])
                                    <i class="bi bi-patch-check-fill text-primary" style="font-size: 0.75rem;"></i>
                                    @endif
                                </div>
                                <small class="text-muted d-block" style="font-size: 0.7rem;"><i class="bi bi-geo-alt me-1"></i>{{ $review['location'] }}</small>
                            </div>
                            <div class="review-quote-icon">
                                <i class="bi bi-quote"></i>
                            </div>
                        </div>
                        <div class="review-card-v2-stars mb-1">
                            @for($s = 0; $s < $review['rating']; $s++)
                            <i class="bi bi-star-fill"></i>
                            @endfor
                            @for($s = $review['rating']; $s < 5; $s++)
                            <i class="bi bi-star"></i>
                            @endfor
                        </div>
                        <h6 class="fw-bold mb-1" style="font-size: 0.85rem;">{{ $review['title'] }}</h6>
                        <p class="review-card-v2-text">{{ $review['text'] }}</p>
                        <div class="review-card-v2-footer">
                            <span class="review-hotel-tag"><i class="bi bi-building me-1"></i>{{ $review['hotel'] }}</span>
                            <small class="text-muted">{{ $review['time'] }}</small>
                        </div>
                    </div>
                    @endforeach
                    {{-- Duplicate for seamless loop --}}
                    @foreach($reviews as $review)
                    <div class="review-card-v2">
                        <div class="review-card-v2-header">
                            <div class="review-avatar">
                                <img src="{{ asset('assets/images/' . $review['image']) }}" alt="{{ $review['name'] }}">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="fw-bold small">{{ $review['name'] }}</span>
                                    @if($review['verified'])
                                    <i class="bi bi-patch-check-fill text-primary" style="font-size: 0.75rem;"></i>
                                    @endif
                                </div>
                                <small class="text-muted d-block" style="font-size: 0.7rem;"><i class="bi bi-geo-alt me-1"></i>{{ $review['location'] }}</small>
                            </div>
                            <div class="review-quote-icon">
                                <i class="bi bi-quote"></i>
                            </div>
                        </div>
                        <div class="review-card-v2-stars mb-1">
                            @for($s = 0; $s < $review['rating']; $s++)
                            <i class="bi bi-star-fill"></i>
                            @endfor
                            @for($s = $review['rating']; $s < 5; $s++)
                            <i class="bi bi-star"></i>
                            @endfor
                        </div>
                        <h6 class="fw-bold mb-1" style="font-size: 0.85rem;">{{ $review['title'] }}</h6>
                        <p class="review-card-v2-text">{{ $review['text'] }}</p>
                        <div class="review-card-v2-footer">
                            <span class="review-hotel-tag"><i class="bi bi-building me-1"></i>{{ $review['hotel'] }}</span>
                            <small class="text-muted">{{ $review['time'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Fade edges -->
        <div class="review-marquee-fade-left"></div>
    </section>

    <!-- ============================
         Crypto Section
         ============================ -->
    
    <img src="{{ asset('icon.png') }}" alt="" width="100%" height="auto">
    
    <section class="py-5 crypto-section">
        <div class="container text-center">
            <span class="section-subtitle text-white-50">Crypto-friendly Bookings</span>
            <h2 class="fw-bold text-white mb-5">Your money is valued here.</h2>

            <div class="position-relative mb-5">
                <div class="crypto-carousel d-flex align-items-center justify-content-center gap-4" id="cryptoCarousel">
                    <button class="carousel-nav-btn carousel-prev" onclick="scrollCarousel('cryptoLogos', -200)">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div class="crypto-logos d-flex gap-4 overflow-hidden" id="cryptoLogos">
                        @php
                            $cryptoColors = ['#9945FF', '#F7931A', '#3CC68A', '#F0B90B', '#E6007A', '#627EEA', '#00D4AA', '#345D9D', '#0033AD', '#14F195'];
                            $cryptoNames = ['SOL', 'BTC', 'USDT', 'BNB', 'DOT', 'ETH', 'AVA', 'ALGO', 'ADA', 'SOL'];
                        @endphp
                        @for($i = 1; $i < 10; $i++)
                        <div class="crypto-logo-item">
                            <span class="fw-bold text-white">
                                <img src="{{ asset('assets/images/payment/' . $i . '.png') }}" alt="" class="img-fluid">
                            </span>
                        </div>
                        @endfor
                    </div>
                    <button class="carousel-nav-btn carousel-next" onclick="scrollCarousel('cryptoLogos', 200)">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="row align-items-center justify-content-center gap-4">
                <div class="col-lg-3 text-lg-start">
                    <p style="color:#c2a082" class="small">We're proud to be the leading crypto-native travel platform, enabling you to book trips worldwide using over 100+ <strong class="text-white">cryptocurrencies</strong> or traditional payment methods—quickly and seamlessly.</p>
                </div>
                <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">
                    <a href="#" class="btn btn-outline-light px-4 py-2 fw-medium">See All Payment Options <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         FAQs Section
         ============================ -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">FAQs</h2>
                <p class="text-muted">Where do you dream of going? Explore exceptional hotels across the world's finest destinations.</p>
            </div>

            <div class="row g-4">
                <!-- FAQ Sidebar Tabs -->
                <div class="col-md-3">
                    <div class="faq-tabs-sidebar">
                        <div class="nav flex-column nav-pills" role="tablist">
                            <button class="nav-link active text-start" data-bs-toggle="pill" data-bs-target="#faq-crypto">Cryptocurrency Payments</button>
                            <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#faq-bookings">Hotel Bookings</button>
                            <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#faq-refunds">Hotel Cancellations & Refunds</button>
                        </div>
                    </div>
                </div>

                <!-- FAQ Content -->
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="faq-crypto">
                            <h5 class="fw-bold mb-4">Cryptocurrency Payments</h5>
                            <div class="accordion" id="faqAccordionCrypto">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            How do I select the cryptocurrency payment option during the booking process?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordionCrypto">
                                        <div class="accordion-body text-muted small">
                                            <p>Once you've selected your desired hotel, flight, or activity, you'll be prompted to enter the necessary personal information (e.g. guest details for hotel check-in or passport information for international flights). After this step, you'll have 100+ payment options to choose from.</p>
                                            <p>Simply select the cryptocurrency you wish to use from:</p>
                                            <ul>
                                                <li>the dropdown list, or</li>
                                                <li>choose to pay with crypto via our payment partners, such as Binance Pay</li>
                                            </ul>
                                            <p>You'll then be provided with a QR code and wallet address. Either scan the QR code with your wallet of choice or manually enter the wallet address and the associated cryptocurrency amount displayed in your wallet (note: NOT the fiat value). Then, complete the transaction using your wallet.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            Which cryptocurrencies are accepted as payment on Travala.com?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordionCrypto">
                                        <div class="accordion-body text-muted small">We accept over 100 cryptocurrencies including Bitcoin, Ethereum, Solana, USDT, BNB, and many more.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            How many payment options does Travala.com currently accept?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordionCrypto">
                                        <div class="accordion-body text-muted small">We currently support over 100+ payment options including both crypto and traditional payment methods.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                            Are there any loyalty programs or rewards for using cryptocurrencies for bookings on Travala.com?
                                        </button>
                                    </h2>
                                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordionCrypto">
                                        <div class="accordion-body text-muted small">Yes! Our AVA Smart Program provides up to 10% back in rewards when you pay with crypto.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                            What customer support options are available if I encounter issues during my booking process?
                                        </button>
                                    </h2>
                                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordionCrypto">
                                        <div class="accordion-body text-muted small">Our 24/7 customer support team is available via live chat and email to help with any booking issues.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="faq-bookings">
                            <h5 class="fw-bold mb-4">Hotel Bookings</h5>
                            <div class="accordion" id="faqAccordionBookings">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqB1">
                                            How do I book a hotel?
                                        </button>
                                    </h2>
                                    <div id="faqB1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordionBookings">
                                        <div class="accordion-body text-muted small">Search for your destination, select your dates and number of guests, browse available hotels, and complete your booking with your preferred payment method.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqB2">
                                            Can I modify my booking after confirmation?
                                        </button>
                                    </h2>
                                    <div id="faqB2" class="accordion-collapse collapse" data-bs-parent="#faqAccordionBookings">
                                        <div class="accordion-body text-muted small">Yes, many of our bookings offer flexible modification options. Check the specific hotel's cancellation policy for details.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="faq-refunds">
                            <h5 class="fw-bold mb-4">Hotel Cancellations & Refunds</h5>
                            <div class="accordion" id="faqAccordionRefunds">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqR1">
                                            How do I cancel my hotel booking?
                                        </button>
                                    </h2>
                                    <div id="faqR1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordionRefunds">
                                        <div class="accordion-body text-muted small">Go to your booking details and click the cancel button. Refund processing depends on the hotel's cancellation policy.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqR2">
                                            How long do refunds take?
                                        </button>
                                    </h2>
                                    <div id="faqR2" class="accordion-collapse collapse" data-bs-parent="#faqAccordionRefunds">
                                        <div class="accordion-body text-muted small">Refunds typically take 5-10 business days depending on your payment method. Crypto refunds are usually processed within 24 hours.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Explore Best Hotels in the World
         ============================ -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Explore the Best Hotels in the World</h2>
                <p class="text-muted">Discover the best countries, regions and cities to visit</p>
            </div>

            <!-- Continent Tabs -->
            <div class="continent-tabs d-flex flex-wrap justify-content-center gap-2 mb-4">
                <button class="continent-tab active" data-continent="europe">EUROPE</button>
                <button class="continent-tab" data-continent="north-america">NORTH AMERICA</button>
                <button class="continent-tab" data-continent="asia">ASIA</button>
                <button class="continent-tab" data-continent="central-america">CENTRAL AMERICA</button>
                <button class="continent-tab" data-continent="oceania">OCEANIA</button>
                <button class="continent-tab" data-continent="south-america">SOUTH AMERICA</button>
                <button class="continent-tab" data-continent="africa">AFRICA</button>
                <button class="continent-tab" data-continent="middle-east">MIDDLE EAST</button>
            </div>

            <!-- Region Cards -->
            <div class="row g-4" id="continentContent">
                <div class="col-md-4">
                    <div class="region-card">
                        <div class="region-card-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-globe2 text-primary"></i>
                                <span class="fw-bold text-primary">Countries</span>
                            </div>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="region-card-body">
                            <ul class="region-list" id="countriesList"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="region-card">
                        <div class="region-card-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-geo-alt text-primary"></i>
                                <span class="fw-bold text-primary">Regions</span>
                            </div>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="region-card-body">
                            <ul class="region-list" id="regionsList"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="region-card">
                        <div class="region-card-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-buildings text-primary"></i>
                                <span class="fw-bold text-primary">Cities</span>
                            </div>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="region-card-body">
                            <ul class="region-list" id="citiesList"></ul>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            (function() {
                const continentData = {
                    'europe': {
                        countries: ['Spain', 'Germany', 'Portugal', 'Switzerland', 'France', 'Italy', 'Poland', 'United Kingdom'],
                        regions: ['Catalonia', 'Community of Madrid', 'Andalusia', 'Balearic Island'],
                        cities: ['Madrid', 'Alcala de Henares', 'Torrej\u00f3n de Ardoz', 'Alcobendas']
                    },
                    'north-america': {
                        countries: ['United States', 'Canada', 'Mexico'],
                        regions: ['California', 'New York State', 'Florida', 'Ontario'],
                        cities: ['New York City', 'Los Angeles', 'Miami', 'Toronto']
                    },
                    'asia': {
                        countries: ['Japan', 'Thailand', 'United Arab Emirates', 'Indonesia'],
                        regions: ['Bali', 'Phuket', 'Tokyo Prefecture', 'Dubai'],
                        cities: ['Tokyo', 'Bangkok', 'Dubai', 'Singapore']
                    },
                    'central-america': {
                        countries: ['Costa Rica', 'Panama', 'Guatemala', 'Belize'],
                        regions: ['Guanacaste', 'Bocas del Toro', 'Antigua Region', 'Ambergris Caye'],
                        cities: ['San Jos\u00e9', 'Panama City', 'Antigua', 'Belize City']
                    },
                    'oceania': {
                        countries: ['Australia', 'New Zealand', 'Fiji'],
                        regions: ['New South Wales', 'Queensland', 'South Island', 'North Island'],
                        cities: ['Sydney', 'Melbourne', 'Auckland', 'Brisbane']
                    },
                    'south-america': {
                        countries: ['Brazil', 'Argentina', 'Colombia', 'Peru'],
                        regions: ['Patagonia', 'Amazon Rainforest', 'Andes Region', 'Atacama Desert'],
                        cities: ['Rio de Janeiro', 'Buenos Aires', 'Medell\u00edn', 'Lima']
                    },
                    'africa': {
                        countries: ['South Africa', 'Morocco', 'Kenya', 'Egypt'],
                        regions: ['Western Cape', 'Maasai Mara', 'Sahara Desert', 'Zanzibar'],
                        cities: ['Cape Town', 'Marrakech', 'Nairobi', 'Cairo']
                    },
                    'middle-east': {
                        countries: ['United Arab Emirates', 'Saudi Arabia', 'Qatar', 'Jordan'],
                        regions: ['Dubai', 'Abu Dhabi', 'Riyadh Region', 'Petra Region'],
                        cities: ['Dubai', 'Doha', 'Riyadh', 'Amman']
                    }
                };

                function renderContinent(continent) {
                    const data = continentData[continent];
                    if (!data) return;

                    const countriesList = document.getElementById('countriesList');
                    const regionsList = document.getElementById('regionsList');
                    const citiesList = document.getElementById('citiesList');

                    countriesList.innerHTML = data.countries.map(c => '<li>' + c + '</li>').join('');
                    regionsList.innerHTML = data.regions.map(r => '<li>' + r + '</li>').join('');
                    citiesList.innerHTML = data.cities.map(c => '<li>' + c + '</li>').join('');
                }

                document.querySelectorAll('.continent-tab').forEach(function(tab) {
                    tab.addEventListener('click', function() {
                        document.querySelectorAll('.continent-tab').forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        renderContinent(this.dataset.continent);
                    });
                });

                // Initialize with Europe
                renderContinent('europe');
            })();
            </script>
        </div>
    </section>

    @include('partials.footer')
    <div class="modal fade" id="guestModal" tabindex="-1" aria-labelledby="guestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guestModalLabel">Select Guests & Rooms</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Adults</span>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeCount('adults', -1)">-</button>
                            <span id="adultsCount" class="mx-3">2</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeCount('adults', 1)">+</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Children</span>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeCount('children', -1)">-</button>
                            <span id="childrenCount" class="mx-3">0</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeCount('children', 1)">+</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Rooms</span>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeCount('rooms', -1)">-</button>
                            <span id="roomsCount" class="mx-3">1</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeCount('rooms', 1)">+</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="updateGuests()">Done</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#checkinField').daterangepicker({
                startDate: moment('{{ now()->format('Y-m-d') }}'),
                endDate: moment('{{ now()->addDay()->format('Y-m-d') }}'),
                locale: {
                    format: 'DD MMM YYYY'
                },
                autoApply: true
            }, function(start, end, label) {
                $('#checkinDisplay').text(start.format('DD MMM YYYY'));
                $('#checkoutDisplay').text(end.format('DD MMM YYYY'));
                $('input[name="checkin"]').val(start.format('YYYY-MM-DD'));
                $('input[name="checkout"]').val(end.format('YYYY-MM-DD'));
            });
        });

        // Initialize counts
        let counts = {adults: 2, children: 0, rooms: 1};

        function changeCount(type, delta) {
            counts[type] = Math.max(0, counts[type] + delta);
            document.getElementById(type + 'Count').textContent = counts[type];
            updateGuestsDisplay();
        }

        function updateGuestsDisplay() {
            document.querySelector('[name="adults"]').value = counts.adults;
            document.querySelector('[name="children"]').value = counts.children;
            document.querySelector('[name="rooms"]').value = counts.rooms;
            document.getElementById('guestDisplayBold').textContent = `${counts.adults} Adults`;
            document.getElementById('guestDisplaySmall').textContent = ` · ${counts.children} Children · ${counts.rooms} Room${counts.rooms > 1 ? 's' : ''}`;
        }

        // Custom dropdown toggle for guests
        document.getElementById('guestDropdownToggle').addEventListener('click', function(e) {
            e.stopPropagation();
            var dd = document.getElementById('guestDropdown');
            dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
        });

        // Close guest dropdown when clicking outside
        document.addEventListener('click', function(e) {
            var dd = document.getElementById('guestDropdown');
            var toggle = document.getElementById('guestDropdownToggle');
            if (!dd.contains(e.target) && !toggle.contains(e.target)) {
                dd.style.display = 'none';
            }
        });

        // Set initial counts
        document.addEventListener('DOMContentLoaded', function() {
            updateGuestsDisplay();
        });
    </script>
    <script src="{{ asset('assets/js/landing.js') }}"></script>
    <script>
    (function() {
        const input = document.getElementById('citySearchInput');
        const hiddenInput = document.getElementById('cityIdInput');
        const dropdown = document.getElementById('cityDropdown');
        const loading = document.getElementById('cityDropdownLoading');
        const results = document.getElementById('cityDropdownResults');
        const empty = document.getElementById('cityDropdownEmpty');
        let debounceTimer = null;
        let currentRequest = null;

        input.addEventListener('input', function() {
            const query = this.value.trim();
            clearTimeout(debounceTimer);

            if (query.length < 2) {
                dropdown.style.display = 'none';
                hiddenInput.value = '';
                return;
            }

            debounceTimer = setTimeout(function() {
                searchCities(query);
            }, 350);
        });

        function searchCities(query) {
            dropdown.style.display = 'block';
            loading.style.display = 'flex';
            results.innerHTML = '';
            empty.style.display = 'none';

            if (currentRequest) currentRequest.abort();

            currentRequest = $.ajax({
                url: '{{ route("search.cities") }}',
                data: { q: query },
                dataType: 'json',
                success: function(data) {
                    loading.style.display = 'none';
                    if (!data || data.length === 0) {
                        empty.style.display = 'block';
                        return;
                    }
                    renderResults(data);
                },
                error: function(xhr, status) {
                    if (status !== 'abort') {
                        loading.style.display = 'none';
                        empty.style.display = 'block';
                    }
                }
            });
        }

        function renderResults(cities) {
            results.innerHTML = '';
            cities.forEach(function(city) {
                const item = document.createElement('div');
                item.className = 'city-search-item';
                item.innerHTML =
                    '<div class="city-search-item-icon"><i class="bi bi-geo-alt"></i></div>' +
                    '<div class="city-search-item-info">' +
                        '<div class="city-search-item-name">' + escapeHtml(city.city_name) + '</div>' +
                        '<div class="city-search-item-meta">' + escapeHtml(city.active_hotels) + ' hotels</div>' +
                    '</div>';
                item.addEventListener('click', function() {
                    input.value = city.city_name;
                    hiddenInput.value = city.city_id;
                    dropdown.style.display = 'none';
                });
                results.appendChild(item);
            });
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Reopen on focus if there's text
        input.addEventListener('focus', function() {
            if (this.value.trim().length >= 2 && results.children.length > 0) {
                dropdown.style.display = 'block';
            }
        });
    })();
    </script>

    {{-- Search Loading Overlay (hidden by default, shown on form submit) --}}
    <div id="searchLoader" style="position:fixed;inset:0;z-index:9999;background:rgba(255,255,255,0.97);display:none;align-items:center;justify-content:center;flex-direction:column;gap:1.5rem;">
        <style>
            @keyframes slPulse { 0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.15);opacity:.7} }
            @keyframes slDots { 0%,80%,100%{transform:scale(0)}40%{transform:scale(1)} }
            .sl-icon{width:64px;height:64px;background:linear-gradient(135deg,#1a237e,#4267B2);border-radius:1rem;display:flex;align-items:center;justify-content:center;animation:slPulse 1.6s ease-in-out infinite;box-shadow:0 8px 32px rgba(26,35,126,.25)}
            .sl-icon i{font-size:1.8rem;color:#fff}
            .sl-text{font-family:'Inter',sans-serif;font-weight:600;font-size:1rem;color:#1a237e}
            .sl-dots{display:flex;gap:6px}
            .sl-dots span{width:8px;height:8px;background:#1a237e;border-radius:50%;animation:slDots 1.2s infinite ease-in-out}
            .sl-dots span:nth-child(2){animation-delay:.15s}
            .sl-dots span:nth-child(3){animation-delay:.3s}
            .sl-sub{font-family:'Inter',sans-serif;font-size:.82rem;color:#94a3b8}
        </style>
        <div class="sl-icon"><i class="bi bi-building"></i></div>
        <div class="sl-text">Finding the best hotels for you</div>
        <div class="sl-dots"><span></span><span></span><span></span></div>
        <div class="sl-sub">Searching across 1,800,000+ properties worldwide</div>
    </div>
    <script>
    (function() {
        var form = document.querySelector('.hero-search-bar form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var loader = document.getElementById('searchLoader');
                if (loader) loader.style.display = 'flex';
                var self = this;
                setTimeout(function() { self.submit(); }, 50);
            });
        }
    })();
    </script>
</body>
</html>
