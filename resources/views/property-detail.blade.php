@extends('layouts.app')
@section('content')
    <!-- Property Detail Content Here -->
    @if($property)
    <!-- ============================
         Photo Gallery
         ============================ -->
    <section class="py-4">
        <div class="container">
            <div class="photo-gallery">
                <div class="row g-2">
                    <div class="col-lg-5">
                        <div class="gallery-main-img">
                            <img src="{{ asset('assets/images/login-1.jpg') }}" alt="{{ $property['propertyName'] ?? 'Hotel' }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row g-2 h-100">
                            <div class="col-12">
                                <div class="gallery-sub-img">
                                    <img src="{{ asset('assets/images/login-1.jpg') }}" alt="Room">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="gallery-sub-img gallery-sub-sm">
                                    <img src="{{ asset('assets/images/login-1.jpg') }}" alt="Room">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="gallery-sub-img gallery-sub-sm position-relative">
                                    <img src="{{ asset('assets/images/login-1.jpg') }}" alt="Room">
                                    <div class="gallery-photo-count">
                                        <i class="bi bi-images me-1"></i> +30 Photos
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="row g-2 h-100">
                            <div class="col-12">
                                <div class="gallery-sub-img">
                                    <img src="{{ asset('assets/images/login-1.jpg') }}" alt="Room">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="gallery-sub-img">
                                    <img src="{{ asset('assets/images/login-1.jpg') }}" alt="Room">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Property Info
         ============================ -->
    <section class="pb-4">
        <div class="container">
            <div class="property-info-card">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h2 class="fw-bold property-name mb-2">{{ $property['propertyName'] ?? 'Hotel Name' }}</h2>
                        <div class="d-flex align-items-center gap-3">
                            <div class="property-rating-badge">
                                <span class="rating-score">9.2</span>
                            </div>
                            <div>
                                <span class="fw-bold">Wonderful</span>
                                <span class="text-muted small ms-1">929 reviews</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 text-lg-end mt-3 mt-lg-0">
                        <div class="property-price-block">
                            <small class="text-muted d-block">from</small>
                            <span class="property-price">US${{ number_format($lowestPrice ?? 0, 2) }}</span>
                            <small class="text-muted d-block">Price per night, 1 room</small>
                            <a href="#rooms-section" class="btn btn-primary-custom text-white px-4 py-2 mt-2 fw-semibold">SELECT ROOM</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Amenity Thumbnails Strip
         ============================ -->
    <section class="pb-4">
        <div class="container">
            <div class="amenity-strip d-flex gap-2 overflow-auto pb-2">
                @php
                    $amenityIcons = [
                        ['icon' => 'bi-wifi', 'label' => 'Free WiFi'],
                        ['icon' => 'bi-cup-hot', 'label' => 'Breakfast'],
                        ['icon' => 'bi-p-circle', 'label' => 'Parking'],
                        ['icon' => 'bi-water', 'label' => 'Pool'],
                        ['icon' => 'bi-snow', 'label' => 'Air Conditioning'],
                        ['icon' => 'bi-tv', 'label' => 'TV'],
                        ['icon' => 'bi-shield-check', 'label' => 'Security'],
                        ['icon' => 'bi-telephone', 'label' => 'Room Service'],
                        ['icon' => 'bi-building', 'label' => 'Elevator'],
                        ['icon' => 'bi-bicycle', 'label' => 'Gym'],
                    ];
                @endphp
                @foreach($amenityIcons as $amenity)
                <div class="amenity-thumb">
                    <i class="bi {{ $amenity['icon'] }}"></i>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================
         Room Listings
         ============================ -->
    <section class="py-4" id="rooms-section">
        <div class="container">
            <div class="rooms-header mb-4">
                <h4 class="fw-bold" style="color: var(--primary-navy);">
                    {{ $roomTypeCount }} room types | {{ $totalDeals }} room deals available
                </h4>
                <div class="room-filters d-flex flex-wrap gap-2 mt-3">
                    <button class="room-filter-pill active">
                        <i class="bi bi-cup-hot-fill me-1"></i> Breakfast Included
                    </button>
                    <button class="room-filter-pill">Free Cancellation</button>
                    <button class="room-filter-pill">Non-smoking</button>
                    <button class="room-filter-pill">Twin</button>
                    <button class="room-filter-pill">Premium</button>
                    <button class="room-filter-pill">
                        <i class="bi bi-sliders me-1"></i> Advanced Filters
                    </button>
                </div>
            </div>

            <!-- Room Type Groups -->
            @foreach($groupedRooms as $groupName => $group)
            <div class="room-type-card mb-4">
                <h5 class="fw-bold room-type-title" style="color: var(--primary-navy);">{{ $groupName }}</h5>

                <div class="row g-0">
                    <!-- Left: Room Image & Details -->
                    <div class="col-lg-3">
                        <div class="room-image-section">
                            <div class="room-image-carousel position-relative">
                                <img src="{{ asset('assets/images/login-1.jpg') }}" alt="{{ $groupName }}" class="room-main-image">
                                <button class="room-img-nav room-img-prev"><i class="bi bi-chevron-left"></i></button>
                                <button class="room-img-nav room-img-next"><i class="bi bi-chevron-right"></i></button>
                                <div class="room-img-dots">
                                    <span class="dot active"></span>
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </div>
                            </div>
                            <div class="room-quick-info mt-2">
                                <a href="#" class="text-primary small fw-medium">
                                    <i class="bi bi-images me-1"></i> Room details and photos
                                </a>
                                <p class="small text-muted mb-1 mt-2">
                                    <i class="bi bi-rulers me-1"></i> 323 sq feet
                                </p>
                                <p class="small text-muted mb-1">
                                    <i class="bi bi-house-door me-1"></i> 1 King Bed
                                </p>
                                <p class="small text-muted mb-1">
                                    <i class="bi bi-arrows-fullscreen me-1"></i> 30 m2 / 323 ft2
                                </p>
                                <p class="small text-muted mb-2">
                                    <i class="bi bi-credit-card me-1"></i> Pay with Card or Crypto
                                </p>
                                <hr>
                                <div class="room-amenities-list">
                                    @php
                                        $firstRoom = $group['rooms'][0] ?? null;
                                        $benefits = $firstRoom['benefits'] ?? [];
                                    @endphp
                                    @foreach($benefits as $benefit)
                                    <span class="small text-muted d-block mb-1">
                                        <i class="bi bi-check-circle text-success me-1"></i> {{ $benefit['translatedBenefitName'] }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Rate Options -->
                    <div class="col-lg-9">
                        <div class="room-rates-section">
                            @foreach($group['rooms'] as $room)
                            <div class="rate-option-row">
                                <div class="row align-items-start g-0">
                                    <!-- Rate Info -->
                                    <div class="col-md-5">
                                        <div class="rate-info p-3">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span class="fw-semibold small">
                                                    {{ $room['freeBreakfast'] ? 'With Breakfast' : 'Room Only' }}
                                                    {{ $room['freeCancellation'] ? '| Free Cancellation' : '' }}
                                                </span>
                                                @if($room['promotionDetail']['description'] ?? false)
                                                <span class="badge bg-success text-white" style="font-size: 0.65rem;">Best price</span>
                                                @endif
                                            </div>

                                            @if(isset($room['cancellationPolicy']))
                                            <p class="small text-success mb-2" style="font-size: 0.7rem;">
                                                <i class="bi bi-check-circle me-1"></i>
                                                @if($room['freeCancellation'])
                                                    Free cancellation until {{ \Carbon\Carbon::parse($room['cancellationPolicy']['date'][0]['onward'] ?? '')->format('M d, Y') }}
                                                @else
                                                    Non-refundable
                                                @endif
                                            </p>
                                            @endif

                                            <p class="small text-muted mb-1" style="font-size: 0.72rem;">
                                                <i class="bi bi-people me-1"></i> {{ $rooms }} room, {{ $adults }} adults
                                            </p>
                                            <p class="small text-muted mb-0" style="font-size: 0.72rem;">
                                                <i class="bi bi-credit-card me-1"></i> Pay with Card or Crypto
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-4">
                                        <div class="rate-price p-3 text-end">
                                            <span class="rate-price-amount">US${{ number_format($room['rate']['inclusive'] ?? 0, 2) }}</span>
                                            <small class="d-block text-muted" style="font-size: 0.68rem;">Cryptocurrency accepted</small>
                                            <small class="d-block text-muted" style="font-size: 0.68rem;">Price per night, {{ $rooms }} room</small>
                                            <small class="d-block text-muted" style="font-size: 0.68rem;">Including taxes and fees</small>

                                            @if(isset($room['promotionDetail']['savingAmount']))
                                            <div class="rate-promo-tag mt-2">
                                                <small style="font-size: 0.65rem;">
                                                    Approx. <strong>US${{ number_format($room['promotionDetail']['savingAmount'], 0) }}</strong> in AVA payback with
                                                    <span class="text-decoration-underline">FREE Smart membership</span>
                                                </small>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Book Button -->
                                    <div class="col-md-3">
                                        <div class="rate-action p-3 text-center">
                                            <button class="btn btn-primary-custom text-white w-100 py-2 fw-semibold">
                                                Book Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ============================
         Customer Reviews
         ============================ -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle">Guest Reviews</span>
                <h2 class="fw-bold">What our Guest say</h2>
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
         Hotel Description
         ============================ -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="hotel-description-section">
                <h3 class="fw-bold mb-4">Hotel Description</h3>
                <p class="text-muted small">
                    {{ $property['propertyName'] ?? 'This hotel' }} is a centrally located property offering excellent amenities
                    and convenient access to local attractions. The property features comfortable rooms with modern furnishings,
                    complimentary high-speed internet, and a selection of dining options. Guests enjoy premium amenities including
                    a fitness center, and attentive customer service to ensure a pleasant stay.
                </p>

                <div class="mt-4">
                    <h5 class="fw-bold mb-3">You need to know</h5>
                    <ul class="hotel-info-list">
                        <li class="small text-muted">Pool access available from 8:00 AM to 8:00 PM</li>
                        <li class="small text-muted">Reservations are required for spa treatments. Reservations can be made by contacting the hotel prior to arrival, using the contact information on the booking confirmation.</li>
                        <li class="small text-muted">This property has connecting/adjoining rooms, which are subject to availability and can be requested by contacting the property using the number on the booking confirmation.</li>
                        <li class="small text-muted">This property allows pets in specific rooms; only surcharges apply and can be found in the Fees section. Guests can request one of these rooms by contacting the property directly, using the contact information on the booking confirmation.</li>
                        <li class="small text-muted">Cashless payment methods are available for all transactions at this property.</li>
                        <li class="small text-muted">Government-issued photo identification and a credit card, debit card, or cash deposit may be required at check-in for incidental charges.</li>
                        <li class="small text-muted">This property welcomes guests of all sexual orientations and gender identities (LGBTQ+ friendly).</li>
                    </ul>
                </div>

                <div class="mt-4">
                    <h5 class="fw-bold mb-3">Special Instructions</h5>
                    <p class="small text-muted">
                        This property offers transfers from the airport (surcharges may apply). Guests must contact the property with arrival details before travel, using the contact information on the booking confirmation. Front desk staff will greet guests on arrival at the property. For any questions, please contact the property using the information on the booking confirmation. Please note that the event Space, Restaurants, and one of the Bars in the property closes. Guests will receive an email with the hotel's terms and conditions prior to their booking for New Year's Special. Guests who book Semi-Inclusive rate plan will receive half-board for guests age 12 and older.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @else
    <!-- No Results -->
    <section class="py-5">
        <div class="container text-center">
            <div class="py-5">
                <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                <h3 class="mt-3 fw-bold">No property found</h3>
                <p class="text-muted">We couldn't find availability for this property. Please try different dates or another property.</p>
                <a href="{{ route('landing') }}" class="btn btn-primary-custom text-white px-4 py-2 mt-2">Back to Home</a>
            </div>
        </div>
    </section>
    @endif
@endsection