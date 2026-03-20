@extends('layouts.app')
@section('content')
        <!-- ============================
         Features Row
         ============================ -->
    <section class="py-5">
        <div class="container">
            <div class="row g-3 g-md-4">
                <div class="col-6 col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-headphones"></i>
                        </div>
                        <h6 class="fw-bold">24/7 Customer Support</h6>
                        <p class="small text-muted mb-0">Contact our team anytime via live chat, phone, or email.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h6 class="fw-bold">100+ Payment Options</h6>
                        <p class="small text-muted mb-0">Book with credit/debit cards or top cryptocurrencies.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                        <h6 class="fw-bold">Rewards & Discounts</h6>
                        <p class="small text-muted mb-0">Earn discounts and cashback sent straight to your OKX/Base wallet.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-tag-fill"></i>
                        </div>
                        <h6 class="fw-bold">Lowest Price Guarantee</h6>
                        <p class="small text-muted mb-0">We'll refund the difference if you find a cheaper hotel.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Promo Cards
         ============================ -->
    <section class="pb-5">
        <div class="container">
            <div class="promo-bar">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-5">
                        <div class="promo-bar-cell-high h-100">
                            <div class="row align-items-center h-100">
                                <div class="col-8 col-sm-7 d-flex flex-column justify-content-center">
                                    <h4 class="fw-bold text-white mb-2" style="font-size: 1.4rem; line-height: 1.3;">Join OKX Today</h4>
                                    <p class="small mb-3" style="color: rgba(255,255,255,0.65);">
                                        Claim $200 in OKX Crypto to trade or spend, and earn up to 10% back
                                        in Credits on every transaction—directly in your account.
                                    </p>
                                    <div>
                                        <a href="#" class="text-white small fw-semibold text-decoration-underline">Get started</a>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-5 text-center">
                                    <img src="{{ asset('img.png') }}" alt="Promo" class="img-fluid" style="max-height: 140px; object-fit: contain; border-radius: 0.5rem;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="promo-bar-cell promo-bar-divider h-100 d-flex flex-column justify-content-center">
                            <h5 class="fw-bold text-white mb-2" style="font-size: 1.3rem; line-height: 1.3;">Traveler-Favorite VIP Stays</h5>
                            <p class="small mb-3" style="color: rgba(255,255,255,0.65);">Top-rated stays with exclusive perks for our members.</p>
                            <div>
                                <a href="#" class="text-white small fw-semibold text-decoration-underline">Explore stays</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="promo-bar-cell promo-bar-divider h-100 d-flex flex-column justify-content-center">
                            <h5 class="fw-bold text-white mb-2" style="font-size: 1.3rem; line-height: 1.3;">Plans change. We get it.</h5>
                            <p class="small mb-3" style="color: rgba(255,255,255,0.65);">Flexible booking options so you can adjust or cancel easily.</p>
                            <div>
                                <a href="#" class="text-white small fw-semibold text-decoration-underline">Explore stays</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================
         Member Deals Section
         ============================ -->
    <section class="pb-5">
        <div class="container">
            <div class="member-deals-banner">
                <div class="member-deals-header">
                    <div>
                        <h3 class="fw-bold mb-1">Members save up to 40% on select stays</h3>
                        <p class="mb-0 text-muted-dark">Showing deals for: <strong>Mar 15 - Mar 20</strong></p>
                    </div>
                    <a href="#" class="btn btn-outline-dark rounded-pill px-4 fw-medium">See more deals</a>
                </div>

                @php
                    $memberDeals = [
                        [
                            'name' => 'Santorini Blue Horizon',
                            'location' => 'Oia, Greece',
                            'score' => 9.2,
                            'scoreLabel' => 'Wonderful',
                            'reviewCount' => 2341,
                            'scoreColor' => '#1a56db',
                            'nightly' => 189,
                            'total' => 945,
                            'originalTotal' => 1180,
                            'nights' => 5,
                            'vip' => true,
                        ],
                        [
                            'name' => 'Maldives Paradise Resort',
                            'location' => 'Malé, Maldives',
                            'score' => 9.0,
                            'scoreLabel' => 'Wonderful',
                            'reviewCount' => 1879,
                            'scoreColor' => '#1a56db',
                            'nightly' => 425,
                            'total' => 2125,
                            'originalTotal' => 2650,
                            'nights' => 5,
                            'vip' => false,
                        ],
                        [
                            'name' => 'Bali Ocean Breeze Villa',
                            'location' => 'Seminyak, Bali',
                            'score' => 8.4,
                            'scoreLabel' => 'Very good',
                            'reviewCount' => 3102,
                            'scoreColor' => '#1a7f37',
                            'nightly' => 156,
                            'total' => 780,
                            'originalTotal' => 975,
                            'nights' => 5,
                            'vip' => true,
                        ],
                        [
                            'name' => 'Cancún Riviera Suites',
                            'location' => 'Cancún, Mexico',
                            'score' => 8.0,
                            'scoreLabel' => 'Very good',
                            'reviewCount' => 1456,
                            'scoreColor' => '#1a7f37',
                            'nightly' => 210,
                            'total' => 1050,
                            'originalTotal' => 1312,
                            'nights' => 5,
                            'vip' => false,
                        ],
                    ];
                @endphp

                <div class="member-deals-grid">
                    @foreach($memberDeals as $deal)
                    <div class="member-deal-card">
                        <div class="member-deal-img">
                            <img src="{{ asset('assets/images/login-1.jpg') }}" alt="{{ $deal['name'] }}">
                            <button class="member-deal-fav" aria-label="Favorite"><i class="bi bi-heart"></i></button>
                            @if($deal['vip'])
                            <span class="member-deal-vip-badge">VIP Access</span>
                            @endif
                            <div class="member-deal-img-nav">
                                <button class="member-deal-nav-btn"><i class="bi bi-chevron-left"></i></button>
                                <button class="member-deal-nav-btn"><i class="bi bi-chevron-right"></i></button>
                            </div>
                        </div>
                        <div class="member-deal-body">
                            <h6 class="fw-bold mb-1">{{ $deal['name'] }}</h6>
                            <p class="small text-muted mb-2">{{ $deal['location'] }}</p>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="member-deal-score" style="background: {{ $deal['scoreColor'] }};">{{ $deal['score'] }}</span>
                                <span class="small"><strong>{{ $deal['scoreLabel'] }}</strong> <span class="text-muted">({{ number_format($deal['reviewCount']) }} reviews)</span></span>
                            </div>
                            <div class="member-deal-member-badge mb-2">
                                <i class="bi bi-percent"></i> Member Price available
                            </div>
                            <div class="member-deal-pricing">
                                <p class="small text-muted mb-0">${{ $deal['nightly'] }} nightly</p>
                                <p class="fw-bold mb-0">${{ number_format($deal['total']) }} total <span class="member-deal-original">${{ number_format($deal['originalTotal']) }}</span></p>
                                <p class="member-deal-tax mb-0"><i class="bi bi-check-circle-fill me-1"></i>Total with taxes and fees</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection