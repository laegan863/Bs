<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolanaTravels - Book Hotels with Crypto & Save Up to 75%</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/property.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
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
                    <li class="nav-item"><a href="#" class="nav-link text-dark">Support</a></li>
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
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- ============================
         Hero Section
         ============================ -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container position-relative" style="z-index: 2;">
            <div class="text-center text-white py-5">
                <h1 class="hero-title fw-bold mb-2">BOOK HOTELS WITH CRYPTO & SAVE UP TO 75%</h1>
                <p class="hero-subtitle mb-5">Pay With Crypto for 2,200,000+ Hotels Worldwide. Best Prices Guaranteed.</p>
            </div>

            <!-- Search Bar -->
            <div class="search-bar mx-auto">
                <form method="GET" action="{{ route('search') }}" class="row g-0 align-items-center">
                    <div class="col-lg-3">
                        <div class="search-field">
                            <i class="bi bi-search text-muted me-2"></i>
                            <div>
                                <input type="text" value="2256959" name="property" class="form-control border-0 p-0 shadow-none" placeholder="Search for Properties or Places">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-field search-field-border">
                            <i class="bi bi-calendar3 text-muted me-2"></i>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block lh-1 mb-1">Check-in</small>
                                <input type="date" name="checkin" class="form-control border-0 p-0 shadow-none fw-medium small search-date-input" id="checkinDate" value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-field search-field-border">
                            <i class="bi bi-calendar3 text-muted me-2"></i>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block lh-1 mb-1">Check-out</small>
                                <input type="date" name="checkout" class="form-control border-0 p-0 shadow-none fw-medium small search-date-input" id="checkoutDate" value="{{ now()->addDay()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="search-field search-field-border">
                            <i class="bi bi-people text-muted me-2"></i>
                            <div>
                                <span class="fw-medium small">2 Adults - 0 Child</span><br>
                                <small class="text-muted">1 Room</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 text-end pe-2">
                        <button type="submit" class="btn btn-primary-custom text-white px-4 py-2">
                            <i class="bi bi-search me-1"></i> Search
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
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <span class="section-subtitle">Explore</span>
                <h2 class="fw-bold">Explore stays in popular destination</h2>
                <p class="text-muted">Average prices based on current calendar month</p>
            </div>

            <!-- Destination Tabs -->
            <ul class="nav nav-pills destination-tabs justify-content-center mb-4" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#beach">Beach</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#culture">Culture</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#ski">Ski</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#family">Family</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#wellness">Wellness and Relaxation</a></li>
            </ul>

            <!-- Hotel Cards Carousel -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="beach">
                    <div class="position-relative">
                        <div class="hotel-carousel" id="hotelCarousel">
                            @for($i = 0; $i < 4; $i++)
                            <div class="hotel-card">
                                <div class="hotel-card-img">
                                    <img src="{{ asset('assets/images/login-1.jpg') }}" alt="Hotel">
                                </div>
                                <div class="hotel-card-body">
                                    <h6 class="fw-bold mb-1">The London Crest Hotel</h6>
                                    <p class="small text-muted mb-1">London, United Kingdom</p>
                                    <span class="fw-bold">$299</span>
                                    <small class="text-muted">avg. nightly price</small>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <button class="carousel-nav-btn carousel-prev" onclick="scrollCarousel('hotelCarousel', -300)">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="carousel-nav-btn carousel-next" onclick="scrollCarousel('hotelCarousel', 300)">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Promotional Banners Slider
         ============================ -->
    <section class="py-5">
        <div class="container">
            <div id="promoBannerCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="promo-banner-card" style="background: linear-gradient(135deg, #2c3e50, #4ca1af);">
                                    <div class="p-4 text-white">
                                        <p class="small mb-1 text-uppercase">Live Now</p>
                                        <h4 class="fw-bold">BY COMPASS<br>NOT A CLOCK</h4>
                                        <p class="small opacity-75">THE WORLD IS TOO BIG TO STAY IN ONE PLACE AND LIFE IS TOO SHORT TO DO JUST ONE THING.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="promo-banner-card" style="background: linear-gradient(135deg, #c0392b, #e74c3c);">
                                    <div class="p-4 text-white">
                                        <p class="small mb-1">Let's Explore</p>
                                        <h4 class="fw-bold">YOUR DREAM<br>DESTINATION</h4>
                                        <span class="badge bg-warning text-dark px-3 py-2 fw-bold">PROMO AND SAVE 35%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-indicators position-relative mt-3">
                    <button type="button" data-bs-target="#promoBannerCarousel" data-bs-slide-to="0" class="active bg-dark"></button>
                    <button type="button" data-bs-target="#promoBannerCarousel" data-bs-slide-to="1" class="bg-dark"></button>
                    <button type="button" data-bs-target="#promoBannerCarousel" data-bs-slide-to="2" class="bg-dark"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Customer Reviews
         ============================ -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle">Customer Reviews</span>
                <h2 class="fw-bold">What our customers say</h2>
            </div>

            <div class="position-relative">
                <div class="review-carousel" id="reviewCarousel">
                    @for($i = 0; $i < 4; $i++)
                    <div class="review-card">
                        <div class="review-card-img">
                            <img src="{{ asset('assets/images/login-1.jpg') }}" alt="Review">
                            <div class="review-card-overlay">
                                <p class="small text-white mb-2">Loved the rooftop view! The hotel was peaceful, well maintained, and perfect for a short weekend trip.</p>
                                <div class="review-stars mb-1">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="review-author">
                                    <span class="badge bg-primary rounded-pill px-3">Victoria Werton</span>
                                    <small class="text-white-50 d-block">2 months ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
                <button class="carousel-nav-btn carousel-prev" onclick="scrollCarousel('reviewCarousel', -300)">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="carousel-nav-btn carousel-next" onclick="scrollCarousel('reviewCarousel', 300)">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- ============================
         Crypto Section
         ============================ -->
    <section class="crypto-section py-5">
        <div class="container text-center">
            <span class="section-subtitle text-white-50">Crypto-friendly Bookings</span>
            <h2 class="fw-bold text-white mb-5">Your money is valued here.</h2>

            <div class="position-relative mb-5">
                <div class="crypto-carousel d-flex align-items-center justify-content-center gap-3" id="cryptoCarousel">
                    <button class="carousel-nav-btn carousel-prev" onclick="scrollCarousel('cryptoLogos', -200)" style="position:relative;left:0;">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div class="crypto-logos d-flex gap-3 overflow-hidden" id="cryptoLogos">
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
                    <button class="carousel-nav-btn carousel-next" onclick="scrollCarousel('cryptoLogos', 200)" style="position:relative;right:0;">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 text-lg-start">
                    <p class="text-white-50 small">We're proud to be the leading crypto-native travel platform, enabling you to book trips worldwide using over 100+ <strong class="text-white">cryptocurrencies</strong> or traditional payment methods—quickly and seamlessly.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
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
            <div class="row g-4">
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
                            <div class="row">
                                <div class="col-6">
                                    <ul class="region-list">
                                        <li>Spain</li>
                                        <li>Germany</li>
                                        <li>Portugal</li>
                                        <li>Switzerland</li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="region-list">
                                        <li>France</li>
                                        <li>Italy</li>
                                        <li>Poland</li>
                                        <li>United Kingdom</li>
                                    </ul>
                                </div>
                            </div>
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
                            <ul class="region-list">
                                <li>Catalonia</li>
                                <li>Community of madrid</li>
                                <li>Andalusia</li>
                                <li>Balearic Island</li>
                            </ul>
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
                            <ul class="region-list">
                                <li>Madrid</li>
                                <li>Alcala de Henares</li>
                                <li>Torrej&oacute;n de Ardoz</li>
                                <li>Alcobendas</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Newsletter
         ============================ -->
    <section class="py-4">
        <div class="container">
            <div class="newsletter-bar">
                <div class="row align-items-center">
                    <div class="col-lg-5 d-flex align-items-center gap-3">
                        <div class="newsletter-icon">
                            <i class="bi bi-envelope-open-heart-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-white mb-0">Join our newsletter</h5>
                            <p class="text-white-50 small mb-0">Sign up and we'll send the best deals to you</p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form class="newsletter-form d-flex gap-2 mt-3 mt-lg-0">
                            <input type="email" class="form-control bg-white" placeholder="Your Email">
                            <button type="submit" class="btn btn-outline-light px-4 fw-medium text-nowrap">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Footer
         ============================ -->
    <footer class="landing-footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-2" style="color: var(--primary-navy);">SolanaTravels</h4>
                    <p class="text-muted small">We accept Credit Card, Debit Card<br>and Cryptocurrency payments.</p>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-bold text-uppercase mb-3">Solana Travels</h6>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Feedback</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Price Guarantee</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-bold text-uppercase mb-3">Support</h6>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Payment Options</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Media Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-bold text-uppercase mb-3">Community</h6>
                    <ul class="footer-links">
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Telegram</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">LinkedIn</a></li>
                        <li><a href="#">Discord</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bottom color bar -->
    <div style="height: 6px; background: linear-gradient(90deg, var(--primary-navy), #3949ab, #5c6bc0);"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/landing.js') }}"></script>
</body>
</html>
