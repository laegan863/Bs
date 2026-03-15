@extends('layouts.app')
@section('content')
        <!-- ============================
         Features Row
         ============================ -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-headphones"></i>
                        </div>
                        <h6 class="fw-bold">24/7 Customer Support</h6>
                        <p class="small text-muted mb-0">Contact our team anytime via live chat, phone, or email.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h6 class="fw-bold">100+ Payment Options</h6>
                        <p class="small text-muted mb-0">Book with credit/debit cards or top cryptocurrencies.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                        <h6 class="fw-bold">Rewards & Discounts</h6>
                        <p class="small text-muted mb-0">Earn discounts and cashback sent straight to your OKX/Base wallet.</p>
                    </div>
                </div>
                <div class="col-md-3">
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
                        <div class="promo-bar-cell h-100">
                            <div class="row align-items-center h-100">
                                <div class="col-7 d-flex flex-column justify-content-center">
                                    <h4 class="fw-bold text-white mb-2" style="font-size: 1.4rem; line-height: 1.3;">Join OKX Today</h4>
                                    <p class="small mb-3" style="color: rgba(255,255,255,0.65);">
                                        Claim $200 in OKX Crypto to trade or spend, and earn up to 10% back
                                        in Credits on every transaction—directly in your account.
                                    </p>
                                    <div>
                                        <a href="#" class="text-white small fw-semibold text-decoration-underline">Get started</a>
                                    </div>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="{{ asset('assets/images/login-1.jpg') }}" alt="Promo" class="img-fluid" style="max-height: 140px; object-fit: contain; border-radius: 0.5rem;">
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
@endsection