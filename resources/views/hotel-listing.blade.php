@extends('layouts.hotel-listing')

@section('content')
<div class="container-fluid px-lg-5 py-2 py-md-4">
    <div class="row">
        {{-- Left Sidebar: Filters --}}
        <div class="col-lg-3 col-md-4 d-none d-md-block">
            <div class="filter-sidebar">
                {{-- Interactive Map --}}
                <div class="filter-map-placeholder mb-3">
                    <div id="hotelMap" style="height: 150px; border-radius: 8px; z-index: 0;"></div>
                </div>

                {{-- Search by Property Name --}}
                <div class="filter-section">
                    <h6 class="filter-title">Search by property name</h6>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="filterPropertyName" class="form-control border-start-0" placeholder="e.g. Marriott">
                    </div>
                </div>

                <hr class="filter-divider">

                {{-- Filters Header --}}
                <h5 class="fw-bold mb-3">Filters</h5>

                {{-- Traveler Experience --}}
                <div class="filter-section">
                    <h6 class="filter-title">Traveler experience</h6>
                    @php
                        $travelerExperiences = ['Eco-certifications', 'LGBTQ welcoming', 'Business friendly', 'Family friendly'];
                    @endphp
                    @foreach($travelerExperiences as $exp)
                    <div class="form-check">
                        <input class="form-check-input filter-experience" type="checkbox" id="exp{{ $loop->index }}" value="{{ $exp }}">
                        <label class="form-check-label" for="exp{{ $loop->index }}">{{ $exp }}</label>
                    </div>
                    @endforeach
                </div>

                <hr class="filter-divider">

                {{-- Guest Rating --}}
                <div class="filter-section">
                    <h6 class="filter-title">Guest rating</h6>
                    <div class="form-check">
                        <input class="form-check-input filter-rating" type="radio" name="guestRating" id="ratingAny" value="0" checked>
                        <label class="form-check-label" for="ratingAny">Any</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input filter-rating" type="radio" name="guestRating" id="rating9" value="9">
                        <label class="form-check-label" for="rating9">Wonderful 9+</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input filter-rating" type="radio" name="guestRating" id="rating8" value="8">
                        <label class="form-check-label" for="rating8">Very good 8+</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input filter-rating" type="radio" name="guestRating" id="rating7" value="7">
                        <label class="form-check-label" for="rating7">Good 7+</label>
                    </div>
                </div>

                <hr class="filter-divider">

                {{-- Star Rating --}}
                <div class="filter-section">
                    <h6 class="filter-title">Star rating</h6>
                    @for($i = 1; $i <= 5; $i++)
                    <div class="form-check">
                        <input class="form-check-input filter-star" type="checkbox" id="star{{ $i }}" value="{{ $i }}">
                        <label class="form-check-label" for="star{{ $i }}">
                            {{ $i }} star{{ $i > 1 ? 's' : '' }}
                        </label>
                    </div>
                    @endfor
                </div>

                <hr class="filter-divider">

                {{-- One Key Benefits --}}
                <div class="filter-section">
                    <h6 class="filter-title">One Key benefits and discounts</h6>
                    <div class="form-check">
                        <input class="form-check-input filter-benefit" type="checkbox" id="benefitDiscount" value="discounted">
                        <label class="form-check-label" for="benefitDiscount">Discounted properties</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input filter-benefit" type="checkbox" id="benefitMember" value="member">
                        <label class="form-check-label" for="benefitMember">Member Prices</label>
                        <div class="form-text small text-muted mt-0" style="margin-left: 1.5rem; font-size: 0.75rem;">Get instant savings when you're signed in</div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input filter-benefit" type="checkbox" id="benefitVIP" value="vip">
                        <label class="form-check-label" for="benefitVIP">VIP Access properties</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input filter-benefit" type="checkbox" id="benefitTopRated" value="top-rated">
                        <label class="form-check-label" for="benefitTopRated">Top-rated stays with member perks</label>
                    </div>
                </div>

                <hr class="filter-divider">

                {{-- Property Type --}}
                <div class="filter-section">
                    <h6 class="filter-title">Property type</h6>
                    @php
                        $propertyTypes = ['Ranch', 'Pousada', 'Pousada (Brazil)', 'Safari', 'Hostel/Backpacker accommodation', 'Townhouse', 'Hotel', 'Pension', 'Bed & breakfast', 'Ryokan', 'Castle'];
                    @endphp
                    @foreach($propertyTypes as $type)
                    <div class="form-check">
                        <input class="form-check-input filter-type" type="checkbox" id="type{{ $loop->index }}" value="{{ $type }}">
                        <label class="form-check-label" for="type{{ $loop->index }}">{{ $type }}</label>
                    </div>
                    @endforeach
                </div>

                <hr class="filter-divider">

                {{-- Amenities --}}
                <div class="filter-section">
                    <h6 class="filter-title">Amenities</h6>
                    <div class="amenities-grid">
                        @php
                            $amenities = [
                                ['icon' => 'bi-wifi', 'label' => 'Free WiFi'],
                                ['icon' => 'bi-p-circle', 'label' => 'Parking Available'],
                                ['icon' => 'bi-airplane', 'label' => 'Airport transfers'],
                                ['icon' => 'bi-cup-hot', 'label' => 'Dining Services'],
                                ['icon' => 'bi-house', 'label' => 'Kitchen'],
                                ['icon' => 'bi-bell', 'label' => 'Concierge'],
                                ['icon' => 'bi-droplet-half', 'label' => 'Spa'],
                                ['icon' => 'bi-tv', 'label' => 'Entertainment'],
                            ];
                        @endphp
                        @foreach($amenities as $amenity)
                        <label class="amenity-card-toggle">
                            <input type="checkbox" class="filter-amenity d-none" value="{{ $amenity['label'] }}">
                            <div class="amenity-card-inner">
                                <i class="bi {{ $amenity['icon'] }}"></i>
                                <span>{{ $amenity['label'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <hr class="filter-divider">

                {{-- Price Range --}}
                <div class="filter-section">
                    <h6 class="filter-title">Price</h6>
                    <div class="mb-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input filter-price-mode" type="radio" name="priceMode" id="priceNightly" value="nightly" checked>
                            <label class="form-check-label small" for="priceNightly">Nightly price</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input filter-price-mode" type="radio" name="priceMode" id="priceTotal" value="total">
                            <label class="form-check-label small" for="priceTotal">Total price</label>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted mb-1">Min</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white">$</span>
                                <input type="text" id="filterPriceMin" class="form-control" value="$0">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted mb-1">Max</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white">$</span>
                                <input type="text" id="filterPriceMax" class="form-control" value="$1,000 +">
                            </div>
                        </div>
                    </div>
                    <div class="price-slider-container">
                        <div class="price-slider-track" id="priceSliderTrack">
                            <div class="price-slider-range" id="priceSliderRange"></div>
                            <input type="range" class="price-slider-input" id="priceSliderMin" min="0" max="1000" value="0" step="10">
                            <input type="range" class="price-slider-input" id="priceSliderMax" min="0" max="1000" value="1000" step="10">
                        </div>
                    </div>
                </div>

                <hr class="filter-divider">

                {{-- Reset Filters --}}
                <button class="btn btn-outline-secondary btn-sm w-100" id="resetFilters">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset all filters
                </button>
            </div>
        </div>

        {{-- Mobile Filter Toggle --}}
        <div class="col-12 d-md-none mb-2">
            <button class="mobile-filter-toggle w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilterOffcanvas">
                <i class="bi bi-funnel"></i> Filters
            </button>
        </div>

        {{-- Mobile Filter Offcanvas --}}
        <div class="offcanvas offcanvas-start filter-offcanvas" tabindex="-1" id="mobileFilterOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold">Filters</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <div class="filter-sidebar" style="position: static; max-height: none; box-shadow: none; padding: 0;">
                    <div class="filter-section">
                        <h6 class="filter-title">Search by property name</h6>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 mobile-filter-name" placeholder="e.g. Marriott">
                        </div>
                    </div>
                    <hr class="filter-divider">
                    <h5 class="fw-bold mb-3">Filters</h5>

                    {{-- Traveler Experience --}}
                    <div class="filter-section">
                        <h6 class="filter-title">Traveler experience</h6>
                        @foreach(['Eco-certifications', 'LGBTQ welcoming', 'Business friendly', 'Family friendly'] as $i => $exp)
                        <div class="form-check">
                            <input class="form-check-input mobile-filter-experience" type="checkbox" value="{{ $exp }}">
                            <label class="form-check-label">{{ $exp }}</label>
                        </div>
                        @endforeach
                    </div>
                    <hr class="filter-divider">

                    {{-- Guest Rating --}}
                    <div class="filter-section">
                        <h6 class="filter-title">Guest rating</h6>
                        <div class="form-check"><input class="form-check-input mobile-filter-rating" type="radio" name="mobileGuestRating" value="0" checked><label class="form-check-label">Any</label></div>
                        <div class="form-check"><input class="form-check-input mobile-filter-rating" type="radio" name="mobileGuestRating" value="9"><label class="form-check-label">Wonderful 9+</label></div>
                        <div class="form-check"><input class="form-check-input mobile-filter-rating" type="radio" name="mobileGuestRating" value="8"><label class="form-check-label">Very good 8+</label></div>
                        <div class="form-check"><input class="form-check-input mobile-filter-rating" type="radio" name="mobileGuestRating" value="7"><label class="form-check-label">Good 7+</label></div>
                    </div>
                    <hr class="filter-divider">

                    {{-- Star Rating --}}
                    <div class="filter-section">
                        <h6 class="filter-title">Star rating</h6>
                        @for($i = 1; $i <= 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input mobile-filter-star" type="checkbox" value="{{ $i }}">
                            <label class="form-check-label">{{ $i }} star{{ $i > 1 ? 's' : '' }}</label>
                        </div>
                        @endfor
                    </div>
                    <hr class="filter-divider">

                    {{-- One Key Benefits --}}
                    <div class="filter-section">
                        <h6 class="filter-title">One Key benefits and discounts</h6>
                        <div class="form-check"><input class="form-check-input mobile-filter-benefit" type="checkbox" value="discounted"><label class="form-check-label">Discounted properties</label></div>
                        <div class="form-check"><input class="form-check-input mobile-filter-benefit" type="checkbox" value="member"><label class="form-check-label">Member Prices</label></div>
                        <div class="form-check"><input class="form-check-input mobile-filter-benefit" type="checkbox" value="vip"><label class="form-check-label">VIP Access properties</label></div>
                        <div class="form-check"><input class="form-check-input mobile-filter-benefit" type="checkbox" value="top-rated"><label class="form-check-label">Top-rated stays with member perks</label></div>
                    </div>
                    <hr class="filter-divider">

                    {{-- Property Type --}}
                    <div class="filter-section">
                        <h6 class="filter-title">Property type</h6>
                        @foreach(['Ranch','Pousada','Pousada (Brazil)','Safari','Hostel/Backpacker accommodation','Townhouse','Hotel','Pension','Bed & breakfast','Ryokan','Castle'] as $type)
                        <div class="form-check">
                            <input class="form-check-input mobile-filter-type" type="checkbox" value="{{ $type }}">
                            <label class="form-check-label">{{ $type }}</label>
                        </div>
                        @endforeach
                    </div>
                    <hr class="filter-divider">

                    {{-- Amenities --}}
                    <div class="filter-section">
                        <h6 class="filter-title">Amenities</h6>
                        <div class="amenities-grid">
                            @foreach([['bi-wifi','Free WiFi'],['bi-p-circle','Parking Available'],['bi-airplane','Airport transfers'],['bi-cup-hot','Dining Services'],['bi-house','Kitchen'],['bi-bell','Concierge'],['bi-droplet-half','Spa'],['bi-tv','Entertainment']] as $am)
                            <label class="amenity-card-toggle">
                                <input type="checkbox" class="mobile-filter-amenity d-none" value="{{ $am[1] }}">
                                <div class="amenity-card-inner">
                                    <i class="bi {{ $am[0] }}"></i>
                                    <span>{{ $am[1] }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <hr class="filter-divider">

                    {{-- Price --}}
                    <div class="filter-section">
                        <h6 class="filter-title">Price</h6>
                        <div class="mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mobile-filter-price-mode" type="radio" name="mobilePriceMode" value="nightly" checked>
                                <label class="form-check-label small">Nightly price</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mobile-filter-price-mode" type="radio" name="mobilePriceMode" value="total">
                                <label class="form-check-label small">Total price</label>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted mb-1">Min</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white">$</span>
                                    <input type="text" class="form-control mobile-filter-price-min" value="$0">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted mb-1">Max</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white">$</span>
                                    <input type="text" class="form-control mobile-filter-price-max" value="$1,000 +">
                                </div>
                            </div>
                        </div>
                        <div class="price-slider-container">
                            <div class="price-slider-track" id="mobilePriceSliderTrack">
                                <div class="price-slider-range" id="mobilePriceSliderRange"></div>
                                <input type="range" class="price-slider-input" id="mobilePriceSliderMin" min="0" max="1000" value="0" step="10">
                                <input type="range" class="price-slider-input" id="mobilePriceSliderMax" min="0" max="1000" value="1000" step="10">
                            </div>
                        </div>
                    </div>
                    <hr class="filter-divider">
                    <button class="btn btn-primary-custom text-white w-100 mb-2" id="mobileApplyFilters" data-bs-dismiss="offcanvas">Apply Filters</button>
                    <button class="btn btn-outline-secondary btn-sm w-100" id="mobileResetFilters">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset all filters
                    </button>
                </div>
            </div>
        </div>

        {{-- Right Content: Hotel Listings --}}
        <div class="col-lg-9 col-md-8">
            {{-- Promo Banner --}}
            <div class="listing-promo-banner mb-4">
                <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                    <img src="{{ asset('searched.png') }}" alt="Crypto" class="img-fluid    ">
                    <div>
                        <span class="fw-bold">For a limited time, OKX users earn an extra $20 in USDC for travel</span>
                        <br><small class="text-muted">Bonus USDC Travel funds expire within 30 days. Offer and OKX terms apply.</small>
                    </div>
                </div>
            </div>

            {{-- Results Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    <span id="visibleCount">{{ $loadedCount ?? $totalProperties }}</span> of {{ $totalProperties }} properties
                </h5>
                <div class="d-flex align-items-center gap-2">
                    <label class="text-muted small mb-0 text-nowrap">Sort by</label>
                    <select class="form-select form-select-sm" id="sortSelect" style="width: auto;">
                        <option value="recommended">Recommended</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="rating">Guest Rating</option>
                        <option value="stars">Star Rating</option>
                    </select>
                </div>
            </div>

            {{-- Hotel Cards --}}
            <div id="hotelListContainer">
                @forelse($hotels as $hotel)
                @php
                    $rating = floatval($hotel['rating_average'] ?? 0);
                    $ratingLabel = $rating >= 9 ? 'Wonderful' : ($rating >= 8 ? 'Very Good' : ($rating >= 7 ? 'Good' : 'Pleasant'));
                    $reviews = intval($hotel['number_of_reviews'] ?? 0);
                    $priceNightly = rand(100, 200);
                    $priceTotal = rand(200, 500);
                @endphp
                <a href="{{ route('search.hotel.detail', ['id' => $hotel['hotel_id'], 'checkin' => $checkin, 'checkout' => $checkout, 'adults' => $adults, 'children' => $children, 'rooms' => $rooms]) }}" class="hotel-listing-card"
                     data-name="{{ strtolower($hotel['hotel_name'] ?? '') }}"
                     data-rating="{{ $hotel['rating_average'] ?? 0 }}"
                     data-stars="{{ floor(floatval($hotel['star_rating'] ?? 0)) }}"
                     data-type="{{ $hotel['accommodation_type'] ?? 'Hotel' }}"
                     data-popularity="{{ $hotel['popularity_score'] ?? 0 }}"
                     data-price-nightly="{{ $priceNightly }}"
                     data-price-total="{{ $priceTotal }}">
                    <div class="row g-0 align-items-stretch">
                        {{-- Hotel Image --}}
                        <div class="col-md-4 col-lg-3">
                            <div class="hotel-listing-img-wrap">
                                @if(!empty($hotel['images']))
                                    <img src="{{ $hotel['images'] }}" alt="{{ $hotel['hotel_name'] ?? 'Hotel' }}" class="hotel-listing-img" loading="lazy">
                                @else
                                    <div class="hotel-listing-img-placeholder">
                                        <i class="bi bi-building fs-1 text-muted"></i>
                                    </div>
                                @endif
                                <span class="hotel-listing-wishlist"><i class="bi bi-heart-fill"></i></span>
                                <span class="hotel-img-nav hotel-img-nav-prev"><i class="bi bi-chevron-left"></i></span>
                                <span class="hotel-img-nav hotel-img-nav-next"><i class="bi bi-chevron-right"></i></span>
                            </div>
                        </div>

                        {{-- Hotel Details --}}
                        <div class="col-md-5 col-lg-6">
                            <div class="hotel-listing-body">
                                <h6 class="hotel-listing-name">
                                    {{ $hotel['hotel_name'] ?? 'Unknown Hotel' }}
                                </h6>
                                <p class="hotel-listing-location">
                                    {{ $hotel['accommodation_type'] ?? '' }}
                                </p>

                                {{-- Tags --}}
                                <div class="hotel-listing-tags">
                                    <span class="hotel-tag"><i class="bi bi-check2 me-1"></i>Dining Services</span>
                                    <span class="hotel-tag"><i class="bi bi-wifi me-1"></i>Free WiFi</span>
                                </div>

                                <div class="hotel-listing-reserve">
                                    Reserve now, pay later
                                </div>

                                {{-- Guest Rating --}}
                                <div class="hotel-listing-rating">
                                    <span class="hotel-rating-badge">{{ number_format($rating, 1) }}</span>
                                    <div class="hotel-rating-text">
                                        <span class="hotel-rating-label">{{ $ratingLabel }}</span>
                                        <span class="hotel-rating-count">{{ $reviews }} reviews</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Price Section --}}
                        <div class="col-md-3 col-lg-3">
                            <div class="hotel-listing-price-section">
                                @if($reviews > 5)
                                    <span class="hotel-availability-badge">
                                        We have {{ rand(1, 5) }} left at
                                    </span>
                                @endif
                                <div class="hotel-listing-price">
                                    <span class="hotel-price-nightly">${{ $priceNightly }} nightly</span>
                                    <span class="hotel-price-total">${{ $priceTotal }} total</span>
                                </div>
                                <div class="hotel-price-note">
                                    <i class="bi bi-check-circle-fill me-1"></i>Total includes taxes and fees
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-search fs-1 text-muted"></i>
                    <h5 class="mt-3">No properties found</h5>
                    <p class="text-muted">Try adjusting your search criteria</p>
                </div>
                @endforelse
            </div>

            {{-- Load More Button --}}
            @if($hasMore ?? false)
            <div id="loadMoreWrap" class="text-center py-4">
                <button id="loadMoreBtn" class="btn btn-outline-primary px-5 py-2 fw-semibold" onclick="loadMoreHotels()">
                    <i class="bi bi-arrow-down-circle me-2"></i>Load More Hotels
                    <span class="text-muted small ms-1">(<span id="remainingCount">{{ $totalProperties - ($loadedCount ?? 0) }}</span> remaining)</span>
                </button>
                <div id="loadMoreSpinner" class="d-none py-3">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted small mt-2 mb-0">Loading more hotels...</p>
                </div>
            </div>
            @endif

            {{-- No Results After Filtering --}}
            <div id="noFilterResults" class="text-center py-5" style="display: none;">
                <i class="bi bi-funnel fs-1 text-muted"></i>
                <h5 class="mt-3">No properties match your filters</h5>
                <p class="text-muted">Try removing some filters to see more results</p>
                <button class="btn btn-outline-primary btn-sm" onclick="document.getElementById('resetFilters').click();">Reset Filters</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Leaflet Map ---
    const hotelData = @json($hotels);
    const coords = hotelData
        .filter(h => h.latitude && h.longitude)
        .map(h => ({
            lat: parseFloat(h.latitude),
            lng: parseFloat(h.longitude),
            name: h.hotel_name || 'Hotel',
            stars: h.star_rating || '',
            rating: h.rating_average || '',
            id: h.hotel_id
        }));

    const map = L.map('hotelMap', { zoomControl: false });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    if (coords.length > 0) {
        const bounds = L.latLngBounds(coords.map(c => [c.lat, c.lng]));
        map.fitBounds(bounds, { padding: [20, 20], maxZoom: 14 });

        coords.forEach(c => {
            L.marker([c.lat, c.lng])
                .addTo(map)
                .bindPopup(`<strong>${c.name}</strong><br>${c.stars} &#9733; &middot; ${c.rating}/10`);
        });
    } else {
        map.setView([20, 0], 2);
    }
    let cards = document.querySelectorAll('.hotel-listing-card');
    const visibleCount = document.getElementById('visibleCount');
    const noFilterResults = document.getElementById('noFilterResults');
    const hotelListContainer = document.getElementById('hotelListContainer');

    // --- Price Range Slider Setup ---
    function setupPriceSlider(minId, maxId, rangeId, minInputId, maxInputId) {
        const sliderMin = document.getElementById(minId);
        const sliderMax = document.getElementById(maxId);
        const sliderRange = document.getElementById(rangeId);
        const inputMin = minInputId ? document.getElementById(minInputId) : null;
        const inputMax = maxInputId ? document.getElementById(maxInputId) : null;
        if (!sliderMin || !sliderMax || !sliderRange) return;

        function updateSliderRange() {
            const min = parseInt(sliderMin.value);
            const max = parseInt(sliderMax.value);
            const totalRange = parseInt(sliderMin.max);
            const left = (min / totalRange) * 100;
            const right = ((totalRange - max) / totalRange) * 100;
            sliderRange.style.left = left + '%';
            sliderRange.style.right = right + '%';
        }

        function formatPrice(val) {
            const num = parseInt(val);
            if (num >= 1000) return '$' + num.toLocaleString() + ' +';
            return '$' + num;
        }

        function parsePrice(str) {
            return parseInt(String(str).replace(/[^0-9]/g, '')) || 0;
        }

        sliderMin.addEventListener('input', function() {
            if (parseInt(sliderMin.value) > parseInt(sliderMax.value)) {
                sliderMin.value = sliderMax.value;
            }
            if (inputMin) inputMin.value = formatPrice(sliderMin.value);
            updateSliderRange();
            applyFilters();
        });

        sliderMax.addEventListener('input', function() {
            if (parseInt(sliderMax.value) < parseInt(sliderMin.value)) {
                sliderMax.value = sliderMin.value;
            }
            if (inputMax) inputMax.value = formatPrice(sliderMax.value);
            updateSliderRange();
            applyFilters();
        });

        if (inputMin) {
            inputMin.addEventListener('change', function() {
                const val = parsePrice(inputMin.value);
                sliderMin.value = Math.min(val, parseInt(sliderMax.value));
                inputMin.value = formatPrice(sliderMin.value);
                updateSliderRange();
                applyFilters();
            });
        }

        if (inputMax) {
            inputMax.addEventListener('change', function() {
                const val = parsePrice(inputMax.value);
                sliderMax.value = Math.max(val, parseInt(sliderMin.value));
                inputMax.value = formatPrice(sliderMax.value);
                updateSliderRange();
                applyFilters();
            });
        }

        updateSliderRange();
    }

    setupPriceSlider('priceSliderMin', 'priceSliderMax', 'priceSliderRange', 'filterPriceMin', 'filterPriceMax');

    // Mobile price slider (separate setup — only applies on "Apply Filters" click)
    const mobileSliderMin = document.getElementById('mobilePriceSliderMin');
    const mobileSliderMax = document.getElementById('mobilePriceSliderMax');
    const mobileSliderRange = document.getElementById('mobilePriceSliderRange');
    const mobileInputMin = document.querySelector('.mobile-filter-price-min');
    const mobileInputMax = document.querySelector('.mobile-filter-price-max');

    function updateMobileSliderRange() {
        if (!mobileSliderMin || !mobileSliderMax || !mobileSliderRange) return;
        const min = parseInt(mobileSliderMin.value);
        const max = parseInt(mobileSliderMax.value);
        const totalRange = parseInt(mobileSliderMin.max);
        mobileSliderRange.style.left = (min / totalRange) * 100 + '%';
        mobileSliderRange.style.right = ((totalRange - max) / totalRange) * 100 + '%';
    }

    function formatPrice(val) {
        const num = parseInt(val);
        if (num >= 1000) return '$' + num.toLocaleString() + ' +';
        return '$' + num;
    }

    function parsePrice(str) {
        return parseInt(String(str).replace(/[^0-9]/g, '')) || 0;
    }

    if (mobileSliderMin) {
        mobileSliderMin.addEventListener('input', function() {
            if (parseInt(mobileSliderMin.value) > parseInt(mobileSliderMax.value)) mobileSliderMin.value = mobileSliderMax.value;
            if (mobileInputMin) mobileInputMin.value = formatPrice(mobileSliderMin.value);
            updateMobileSliderRange();
        });
    }
    if (mobileSliderMax) {
        mobileSliderMax.addEventListener('input', function() {
            if (parseInt(mobileSliderMax.value) < parseInt(mobileSliderMin.value)) mobileSliderMax.value = mobileSliderMin.value;
            if (mobileInputMax) mobileInputMax.value = formatPrice(mobileSliderMax.value);
            updateMobileSliderRange();
        });
    }
    if (mobileInputMin) {
        mobileInputMin.addEventListener('change', function() {
            const val = parsePrice(mobileInputMin.value);
            mobileSliderMin.value = Math.min(val, parseInt(mobileSliderMax.value));
            mobileInputMin.value = formatPrice(mobileSliderMin.value);
            updateMobileSliderRange();
        });
    }
    if (mobileInputMax) {
        mobileInputMax.addEventListener('change', function() {
            const val = parsePrice(mobileInputMax.value);
            mobileSliderMax.value = Math.max(val, parseInt(mobileSliderMin.value));
            mobileInputMax.value = formatPrice(mobileSliderMax.value);
            updateMobileSliderRange();
        });
    }
    updateMobileSliderRange();

    // --- Apply Filters ---
    function applyFilters() {
        const nameQuery = document.getElementById('filterPropertyName').value.toLowerCase().trim();
        const selectedRating = document.querySelector('.filter-rating:checked')?.value || '0';
        const selectedStars = Array.from(document.querySelectorAll('.filter-star:checked')).map(cb => cb.value);
        const selectedTypes = Array.from(document.querySelectorAll('.filter-type:checked')).map(cb => cb.value);

        // Price filter
        const priceMode = document.querySelector('.filter-price-mode:checked')?.value || 'nightly';
        const priceMin = parseInt(document.getElementById('priceSliderMin')?.value) || 0;
        const priceMax = parseInt(document.getElementById('priceSliderMax')?.value) || 1000;

        let visible = 0;

        cards.forEach(card => {
            let show = true;

            // Name filter
            if (nameQuery && !card.dataset.name.includes(nameQuery)) {
                show = false;
            }

            // Guest rating filter
            if (selectedRating !== '0') {
                const cardRating = parseFloat(card.dataset.rating);
                if (cardRating < parseFloat(selectedRating)) {
                    show = false;
                }
            }

            // Star rating filter
            if (selectedStars.length > 0) {
                const cardStars = card.dataset.stars;
                if (!selectedStars.includes(cardStars)) {
                    show = false;
                }
            }

            // Property type filter
            if (selectedTypes.length > 0) {
                const cardType = card.dataset.type;
                if (!selectedTypes.includes(cardType)) {
                    show = false;
                }
            }

            // Price filter
            if (show) {
                const cardPrice = priceMode === 'nightly'
                    ? parseFloat(card.dataset.priceNightly || 0)
                    : parseFloat(card.dataset.priceTotal || 0);
                if (cardPrice < priceMin || (priceMax < 1000 && cardPrice > priceMax)) {
                    show = false;
                }
            }

            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        visibleCount.textContent = visible;
        noFilterResults.style.display = visible === 0 && cards.length > 0 ? '' : 'none';
        hotelListContainer.style.display = visible === 0 && cards.length > 0 ? 'none' : '';
    }

    function applySorting() {
        const sortValue = document.getElementById('sortSelect').value;
        const container = document.getElementById('hotelListContainer');
        const cardsArray = Array.from(cards);

        cardsArray.sort((a, b) => {
            switch (sortValue) {
                case 'price-low':
                    return parseFloat(a.dataset.priceNightly || 0) - parseFloat(b.dataset.priceNightly || 0);
                case 'price-high':
                    return parseFloat(b.dataset.priceNightly || 0) - parseFloat(a.dataset.priceNightly || 0);
                case 'rating':
                    return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
                case 'stars':
                    return parseInt(b.dataset.stars) - parseInt(a.dataset.stars);
                case 'recommended':
                default:
                    return parseInt(b.dataset.popularity) - parseInt(a.dataset.popularity);
            }
        });

        cardsArray.forEach(card => container.appendChild(card));
    }

    // Bind filter events
    document.getElementById('filterPropertyName').addEventListener('input', applyFilters);
    document.querySelectorAll('.filter-rating').forEach(el => el.addEventListener('change', applyFilters));
    document.querySelectorAll('.filter-star').forEach(el => el.addEventListener('change', applyFilters));
    document.querySelectorAll('.filter-type').forEach(el => el.addEventListener('change', applyFilters));
    document.querySelectorAll('.filter-experience').forEach(el => el.addEventListener('change', applyFilters));
    document.querySelectorAll('.filter-benefit').forEach(el => el.addEventListener('change', applyFilters));
    document.querySelectorAll('.filter-amenity').forEach(el => el.addEventListener('change', applyFilters));
    document.querySelectorAll('.filter-price-mode').forEach(el => el.addEventListener('change', applyFilters));

    // Sort
    document.getElementById('sortSelect').addEventListener('change', function() {
        applySorting();
        applyFilters();
    });

    // Reset
    document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('filterPropertyName').value = '';
        document.querySelectorAll('.filter-rating').forEach(el => el.checked = el.value === '0');
        document.querySelectorAll('.filter-star').forEach(el => el.checked = false);
        document.querySelectorAll('.filter-type').forEach(el => el.checked = false);
        document.querySelectorAll('.filter-experience').forEach(el => el.checked = false);
        document.querySelectorAll('.filter-benefit').forEach(el => el.checked = false);
        document.querySelectorAll('.filter-amenity').forEach(el => el.checked = false);
        document.querySelectorAll('.filter-price-mode').forEach(el => el.checked = el.value === 'nightly');
        const sliderMin = document.getElementById('priceSliderMin');
        const sliderMax = document.getElementById('priceSliderMax');
        if (sliderMin) sliderMin.value = 0;
        if (sliderMax) sliderMax.value = 1000;
        document.getElementById('filterPriceMin').value = '$0';
        document.getElementById('filterPriceMax').value = '$1,000 +';
        const sliderRange = document.getElementById('priceSliderRange');
        if (sliderRange) { sliderRange.style.left = '0%'; sliderRange.style.right = '0%'; }
        document.getElementById('sortSelect').value = 'recommended';
        applyFilters();
    });

    // Mobile Apply Filters - sync to desktop
    const mobileApplyBtn = document.getElementById('mobileApplyFilters');
    if (mobileApplyBtn) {
        mobileApplyBtn.addEventListener('click', function() {
            // Sync name
            const mobileName = document.querySelector('.mobile-filter-name');
            if (mobileName) document.getElementById('filterPropertyName').value = mobileName.value;

            // Sync rating
            const mobileRating = document.querySelector('.mobile-filter-rating:checked');
            if (mobileRating) {
                document.querySelectorAll('.filter-rating').forEach(el => el.checked = el.value === mobileRating.value);
            }

            // Sync stars
            document.querySelectorAll('.filter-star').forEach(el => el.checked = false);
            document.querySelectorAll('.mobile-filter-star:checked').forEach(mEl => {
                const desktopEl = document.querySelector('.filter-star[value="' + mEl.value + '"]');
                if (desktopEl) desktopEl.checked = true;
            });

            // Sync types
            document.querySelectorAll('.filter-type').forEach(el => el.checked = false);
            document.querySelectorAll('.mobile-filter-type:checked').forEach(mEl => {
                const desktopEl = document.querySelector('.filter-type[value="' + CSS.escape(mEl.value) + '"]');
                if (desktopEl) desktopEl.checked = true;
            });

            // Sync price slider
            const mSliderMin = document.getElementById('mobilePriceSliderMin');
            const mSliderMax = document.getElementById('mobilePriceSliderMax');
            const dSliderMin = document.getElementById('priceSliderMin');
            const dSliderMax = document.getElementById('priceSliderMax');
            if (mSliderMin && dSliderMin) dSliderMin.value = mSliderMin.value;
            if (mSliderMax && dSliderMax) dSliderMax.value = mSliderMax.value;
            document.getElementById('filterPriceMin').value = formatPrice(dSliderMin.value);
            document.getElementById('filterPriceMax').value = formatPrice(dSliderMax.value);
            const sliderRange = document.getElementById('priceSliderRange');
            if (sliderRange) {
                sliderRange.style.left = (parseInt(dSliderMin.value) / 1000) * 100 + '%';
                sliderRange.style.right = ((1000 - parseInt(dSliderMax.value)) / 1000) * 100 + '%';
            }

            // Sync price mode
            const mobilePriceMode = document.querySelector('.mobile-filter-price-mode:checked');
            if (mobilePriceMode) {
                document.querySelectorAll('.filter-price-mode').forEach(el => el.checked = el.value === mobilePriceMode.value);
            }

            applyFilters();
        });
    }

    // Mobile Reset
    const mobileResetBtn = document.getElementById('mobileResetFilters');
    if (mobileResetBtn) {
        mobileResetBtn.addEventListener('click', function() {
            const mobileName = document.querySelector('.mobile-filter-name');
            if (mobileName) mobileName.value = '';
            document.querySelectorAll('.mobile-filter-rating').forEach(el => el.checked = el.value === '0');
            document.querySelectorAll('.mobile-filter-star').forEach(el => el.checked = false);
            document.querySelectorAll('.mobile-filter-type').forEach(el => el.checked = false);
            document.querySelectorAll('.mobile-filter-experience').forEach(el => el.checked = false);
            document.querySelectorAll('.mobile-filter-benefit').forEach(el => el.checked = false);
            document.querySelectorAll('.mobile-filter-amenity').forEach(el => el.checked = false);
            document.querySelectorAll('.mobile-filter-price-mode').forEach(el => el.checked = el.value === 'nightly');
            if (mobileSliderMin) mobileSliderMin.value = 0;
            if (mobileSliderMax) mobileSliderMax.value = 1000;
            if (mobileInputMin) mobileInputMin.value = '$0';
            if (mobileInputMax) mobileInputMax.value = '$1,000 +';
            updateMobileSliderRange();
        });
    }

    // Re-bind filters for dynamically added cards
    window.rebindFilters = function() {
        cards = document.querySelectorAll('.hotel-listing-card');
    };
});

// --- Load More Hotels ---
let currentOffset = {{ $loadedCount ?? count($hotels) }};
const batchSize = 50;
const cityId = '{{ $property }}';
const searchParams = {
    checkin: '{{ $checkin }}',
    checkout: '{{ $checkout }}',
    adults: '{{ $adults }}',
    children: '{{ $children }}',
    rooms: '{{ $rooms }}'
};

function loadMoreHotels() {
    const btn = document.getElementById('loadMoreBtn');
    const spinner = document.getElementById('loadMoreSpinner');
    btn.classList.add('d-none');
    spinner.classList.remove('d-none');

    $.ajax({
        url: '{{ route("search.hotels.more") }}',
        data: { city_id: cityId, offset: currentOffset, limit: batchSize },
        dataType: 'json',
        success: function(data) {
            spinner.classList.add('d-none');

            if (!data.hotels || data.hotels.length === 0) {
                document.getElementById('loadMoreWrap').innerHTML =
                    '<p class="text-muted small py-3">All hotels loaded</p>';
                return;
            }

            const container = document.getElementById('hotelListContainer');
            data.hotels.forEach(function(hotel) {
                const rating = parseFloat(hotel.rating_average || 0);
                const ratingLabel = rating >= 9 ? 'Wonderful' : (rating >= 8 ? 'Very Good' : (rating >= 7 ? 'Good' : 'Pleasant'));
                const reviews = parseInt(hotel.number_of_reviews || 0);
                const stars = Math.floor(parseFloat(hotel.star_rating || 0));
                const detailUrl = '{{ route("search.hotel.detail", ["id" => "__ID__"]) }}'.replace('__ID__', hotel.hotel_id)
                    + '&checkin=' + encodeURIComponent(searchParams.checkin)
                    + '&checkout=' + encodeURIComponent(searchParams.checkout)
                    + '&adults=' + searchParams.adults
                    + '&children=' + searchParams.children
                    + '&rooms=' + searchParams.rooms;

                const imageHtml = hotel.images
                    ? '<img src="' + escapeAttr(hotel.images) + '" alt="' + escapeAttr(hotel.hotel_name || 'Hotel') + '" class="hotel-listing-img" loading="lazy">'
                    : '<div class="hotel-listing-img-placeholder"><i class="bi bi-building fs-1 text-muted"></i></div>';

                const card = document.createElement('a');
                card.href = detailUrl;
                card.className = 'hotel-listing-card';
                card.dataset.name = (hotel.hotel_name || '').toLowerCase();
                card.dataset.rating = hotel.rating_average || 0;
                card.dataset.stars = stars;
                card.dataset.type = hotel.accommodation_type || 'Hotel';
                card.dataset.popularity = hotel.popularity_score || 0;
                var nightlyPrice = Math.floor(Math.random() * 100) + 100;
                var totalPrice = Math.floor(Math.random() * 300) + 200;
                card.dataset.priceNightly = nightlyPrice;
                card.dataset.priceTotal = totalPrice;
                card.innerHTML =
                    '<div class="row g-0 align-items-stretch">' +
                        '<div class="col-md-4 col-lg-3"><div class="hotel-listing-img-wrap">' +
                            imageHtml +
                            '<span class="hotel-listing-wishlist"><i class="bi bi-heart-fill"></i></span>' +
                            '<span class="hotel-img-nav hotel-img-nav-prev"><i class="bi bi-chevron-left"></i></span>' +
                            '<span class="hotel-img-nav hotel-img-nav-next"><i class="bi bi-chevron-right"></i></span>' +
                        '</div></div>' +
                        '<div class="col-md-5 col-lg-6"><div class="hotel-listing-body">' +
                            '<h6 class="hotel-listing-name">' + escapeHtml(hotel.hotel_name || 'Unknown Hotel') + '</h6>' +
                            '<p class="hotel-listing-location">' + escapeHtml(hotel.accommodation_type || '') + '</p>' +
                            '<div class="hotel-listing-tags">' +
                                '<span class="hotel-tag"><i class="bi bi-check2 me-1"></i>Dining Services</span>' +
                                '<span class="hotel-tag"><i class="bi bi-wifi me-1"></i>Free WiFi</span>' +
                            '</div>' +
                            '<div class="hotel-listing-reserve">Reserve now, pay later</div>' +
                            '<div class="hotel-listing-rating">' +
                                '<span class="hotel-rating-badge">' + rating.toFixed(1) + '</span>' +
                                '<div class="hotel-rating-text">' +
                                    '<span class="hotel-rating-label">' + ratingLabel + '</span>' +
                                    '<span class="hotel-rating-count">' + reviews + ' reviews</span>' +
                                '</div>' +
                            '</div>' +
                        '</div></div>' +
                        '<div class="col-md-3 col-lg-3"><div class="hotel-listing-price-section">' +
                            (reviews > 5 ? '<span class="hotel-availability-badge">We have ' + (Math.floor(Math.random() * 5) + 1) + ' left at</span>' : '') +
                            '<div class="hotel-listing-price">' +
                                '<span class="hotel-price-nightly">$' + nightlyPrice + ' nightly</span>' +
                                '<span class="hotel-price-total">$' + totalPrice + ' total</span>' +
                            '</div>' +
                            '<div class="hotel-price-note"><i class="bi bi-check-circle-fill me-1"></i>Total includes taxes and fees</div>' +
                        '</div></div>' +
                    '</div>';
                container.appendChild(card);
            });

            currentOffset += data.hotels.length;

            // Update counts
            document.getElementById('visibleCount').textContent = currentOffset;
            if (document.getElementById('remainingCount')) {
                document.getElementById('remainingCount').textContent = data.total_count - currentOffset;
            }

            // Re-bind filters to include new cards
            if (window.rebindFilters) window.rebindFilters();

            if (data.has_more) {
                btn.classList.remove('d-none');
            } else {
                document.getElementById('loadMoreWrap').innerHTML =
                    '<p class="text-muted small py-3"><i class="bi bi-check-circle me-1"></i>All ' + data.total_count + ' hotels loaded</p>';
            }
        },
        error: function() {
            spinner.classList.add('d-none');
            btn.classList.remove('d-none');
            btn.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Retry Loading';
        }
    });
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function escapeAttr(str) {
    return String(str).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}
</script>
@endsection