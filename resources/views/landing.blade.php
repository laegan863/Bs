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
                            <i class="bi bi-headset"></i>
                        </div>
                        <h6 class="fw-bold">24/7 Customer Support</h6>
                        <p class="small text-muted mb-0">Contact our support team anytime via live chat or email</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>
                        <h6 class="fw-bold">100+ Payment Options</h6>
                        <p class="small text-muted mb-0">Book with credit/debit cards and leading cryptocurrencies</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-gift"></i>
                        </div>
                        <h6 class="fw-bold">Rewards & Discounts</h6>
                        <p class="small text-muted mb-0">Get rewards and discounts with the AVA Smart Program</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h6 class="fw-bold">Best Price Guarantee</h6>
                        <p class="small text-muted mb-0">If you find a cheaper hotel deal, we'll refund the difference!</p>
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
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="promo-card promo-card-okx">
                        <div class="row align-items-center">
                            <div class="col-7">
                                <h4 class="fw-bold text-white mb-2">Get up to 25% Credits Back on OKX Pay</h4>
                                <p class="text-white-50 small mb-3">No endless tabs. Compare your hotel options side by side in one place.</p>
                                <a href="#" class="text-white small fw-medium text-decoration-underline">Get started</a>
                            </div>
                            <div class="col-5 text-center">
                                <div class="promo-card-image">
                                    <i class="bi bi-trophy-fill" style="font-size:4rem;color:#f5c542;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="promo-card promo-card-stays">
                        <h5 class="fw-bold text-white mb-2">Stays that deliver</h5>
                        <p class="text-white-50 small mb-3">Traveler-favorite VIP Access stays come with high ratings and perks for our top-tier members.</p>
                        <a href="#" class="text-white small fw-medium text-decoration-underline">Explore stays</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="promo-card promo-card-plans">
                        <h5 class="fw-bold text-white mb-2">Plans change. We get it.</h5>
                        <p class="text-white-50 small mb-3">Flexible booking options so you can adjust or cancel easily.</p>
                        <a href="#" class="text-white small fw-medium text-decoration-underline">Explore stays</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection