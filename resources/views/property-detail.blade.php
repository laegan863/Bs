@extends('layouts.app')
@section('content')
    <!-- Property Detail Content Here -->
    @if($property)
    <!-- ============================
         Photo Gallery
         ============================ -->
    @php
        $pictures = $data['images']['pictures']['picture'] ?? [];
        $totalPhotos = count($pictures);
    @endphp
    <section class="py-4">
        <div class="container">
            <div class="photo-gallery">
                <div class="row g-2">
                    {{-- Main Hero Image --}}
                    <div class="col-lg-6">
                        <div class="gallery-item gallery-hero" onclick="openLightbox(0)">
                            <img src="{{ $pictures[0]['URL'] ?? asset('assets/images/login-1.jpg') }}" alt="{{ is_array($pictures[0]['caption'] ?? '') ? $property['propertyName'] : ($pictures[0]['caption'] ?? $property['propertyName']) }}">
                            <div class="gallery-overlay">
                                <div class="gallery-overlay-content">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                    @if(!is_array($pictures[0]['caption'] ?? []) && ($pictures[0]['caption'] ?? ''))
                                    <span>{{ $pictures[0]['caption'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Right Grid --}}
                    <div class="col-lg-6">
                        <div class="row g-2">
                            {{-- Top row: 2 images --}}
                            <div class="col-6">
                                <div class="gallery-item gallery-sm" onclick="openLightbox(1)">
                                    <img src="{{ $pictures[1]['URL'] ?? asset('assets/images/login-1.jpg') }}" alt="">
                                    <div class="gallery-overlay">
                                        <div class="gallery-overlay-content">
                                            <i class="bi bi-arrows-fullscreen"></i>
                                            @if(!is_array($pictures[1]['caption'] ?? []) && ($pictures[1]['caption'] ?? ''))
                                            <span>{{ $pictures[1]['caption'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="gallery-item gallery-sm" onclick="openLightbox(2)">
                                    <img src="{{ $pictures[2]['URL'] ?? asset('assets/images/login-1.jpg') }}" alt="">
                                    <div class="gallery-overlay">
                                        <div class="gallery-overlay-content">
                                            <i class="bi bi-arrows-fullscreen"></i>
                                            @if(!is_array($pictures[2]['caption'] ?? []) && ($pictures[2]['caption'] ?? ''))
                                            <span>{{ $pictures[2]['caption'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Bottom row: 3 images, last one shows photo count --}}
                            <div class="col-4">
                                <div class="gallery-item gallery-xs" onclick="openLightbox(3)">
                                    <img src="{{ $pictures[3]['URL'] ?? asset('assets/images/login-1.jpg') }}" alt="">
                                    <div class="gallery-overlay">
                                        <div class="gallery-overlay-content">
                                            <i class="bi bi-arrows-fullscreen"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="gallery-item gallery-xs" onclick="openLightbox(4)">
                                    <img src="{{ $pictures[4]['URL'] ?? asset('assets/images/login-1.jpg') }}" alt="">
                                    <div class="gallery-overlay">
                                        <div class="gallery-overlay-content">
                                            <i class="bi bi-arrows-fullscreen"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="gallery-item gallery-xs gallery-more" onclick="openLightbox(5)">
                                    <img src="{{ $pictures[5]['URL'] ?? asset('assets/images/login-1.jpg') }}" alt="">
                                    <div class="gallery-more-overlay">
                                        <i class="bi bi-images"></i>
                                        <span>+{{ $totalPhotos - 5 }} Photos</span>
                                    </div>
                                    <div class="gallery-overlay">
                                        <div class="gallery-overlay-content">
                                            <i class="bi bi-arrows-fullscreen"></i>
                                        </div>
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
         Fullscreen Lightbox
         ============================ -->
    <div class="lightbox-backdrop" id="lightboxBackdrop" onclick="closeLightbox()">
        <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
        <button class="lightbox-nav lightbox-prev" onclick="event.stopPropagation(); navigateLightbox(-1)"><i class="bi bi-chevron-left"></i></button>
        <button class="lightbox-nav lightbox-next" onclick="event.stopPropagation(); navigateLightbox(1)"><i class="bi bi-chevron-right"></i></button>
        <div class="lightbox-content" onclick="event.stopPropagation()">
            <img id="lightboxImg" src="" alt="">
            <div class="lightbox-caption" id="lightboxCaption"></div>
            <div class="lightbox-counter" id="lightboxCounter"></div>
        </div>
    </div>

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
                            <a href="#rooms-section" class="btn btn-primary-custom btn-hover-glow text-white px-4 py-2 mt-2 fw-semibold">SELECT ROOM <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Amenity Thumbnails Strip
         ============================ -->
    @php
        $iconMap = [
            'Free Wi-Fi in all rooms!' => 'bi-wifi',
            'Wi-Fi in public areas' => 'bi-wifi',
            'Internet' => 'bi-globe',
            'Swimming pool' => 'bi-water',
            'Swimming pool [outdoor]' => 'bi-water',
            'Fitness center' => 'bi-bicycle',
            'Gym/fitness' => 'bi-bicycle',
            'Bar' => 'bi-cup-straw',
            'Restaurants' => 'bi-shop',
            'Elevator' => 'bi-building',
            'Laundry service' => 'bi-basket',
            'Air conditioning' => 'bi-snow',
            'Parking' => 'bi-p-circle',
            'Car park [on-site]' => 'bi-p-circle',
            'Security [24-hour]' => 'bi-shield-check',
            'Front desk [24-hour]' => 'bi-clock',
            'Breakfast [buffet]' => 'bi-cup-hot',
            'Breakfast [continental]' => 'bi-cup-hot',
            'Concierge' => 'bi-person-badge',
            'Luggage storage' => 'bi-bag',
            'Wheelchair accessible' => 'bi-universal-access',
            'Family room' => 'bi-people',
            'Smoke-free property' => 'bi-slash-circle',
            'Taxi service' => 'bi-taxi-front',
            'Currency exchange' => 'bi-currency-exchange',
            'Computer station' => 'bi-pc-display',
            'Poolside bar' => 'bi-cup-straw',
            'Vending machine' => 'bi-box',
            'Contactless check-in/out' => 'bi-phone',
            'CCTV in common areas' => 'bi-camera-video',
            'Shower' => 'bi-droplet',
            'Hair dryer' => 'bi-wind',
            'Coffee/tea maker' => 'bi-cup-hot-fill',
            'Telephone' => 'bi-telephone',
            'Desk' => 'bi-pencil-square',
            'In-room safe box' => 'bi-safe',
            'Private bathroom' => 'bi-door-open',
            'Satellite/cable channels' => 'bi-tv',
            'Non-smoking rooms' => 'bi-slash-circle',
        ];
        $allFacilities = $data['facilities']['facilities']['facility'] ?? [];
        $highlightFacilities = collect($allFacilities)->filter(fn($f) => isset($iconMap[$f['property_name']]))->unique('property_name')->take(12);
    @endphp
    <section class="pb-4">
        <div class="container">
            <div class="amenity-strip d-flex gap-2 overflow-auto pb-2">
                @foreach($highlightFacilities as $facility)
                <div class="amenity-thumb" title="{{ $facility['property_translated_name'] }}">
                    <i class="bi {{ $iconMap[$facility['property_name']] ?? 'bi-check-circle' }}"></i>
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
            @php
                // Build a lookup of room type details by hotel_room_type_id
                $roomTypeLookup = [];
                $roomTypes = $data['room_images']['roomtypes']['roomtype'] ?? [];
                foreach ($roomTypes as $rt) {
                    $roomTypeLookup[$rt['hotel_room_type_id']] = $rt;
                }
            @endphp
            @foreach($groupedRooms as $groupName => $group)
            @php
                $firstRoom = $group['rooms'][0] ?? null;
                $matchedRoomType = $roomTypeLookup[strval($firstRoom['parentRoomId'] ?? $firstRoom['roomId'] ?? '')] ?? null;
                $roomImages = [];
                if ($matchedRoomType) {
                    $pics = $matchedRoomType['hotel_room_type_pictures']['hotel_room_type_picture'] ?? [];
                    $roomImages = is_array($pics) ? $pics : [$pics];
                }
                $mainRoomImage = $roomImages[0] ?? ($matchedRoomType['hotel_room_type_picture'] ?? asset('assets/images/login-1.jpg'));
                $bedType = $matchedRoomType['bed_type'] ?? 'N/A';
                $roomSize = $matchedRoomType['size_of_room'] ?? null;
                $maxOccupancy = $matchedRoomType['max_occupancy_per_room'] ?? null;
                $views = $matchedRoomType['views'] ?? null;
                $roomImageCount = count($roomImages);
            @endphp
            <div class="room-type-card mb-4">
                <h5 class="fw-bold room-type-title" style="color: var(--primary-navy);">{{ $groupName }}</h5>

                <div class="row g-0">
                    <!-- Left: Room Image & Details -->
                    <div class="col-lg-3">
                        <div class="room-image-section">
                            <div class="room-image-carousel position-relative" id="roomCarousel-{{ Str::slug($groupName) }}" data-images='@json($roomImages)' data-index="0">
                                <img src="{{ $mainRoomImage }}" alt="{{ $groupName }}" class="room-main-image" id="roomImg-{{ Str::slug($groupName) }}" onclick="openRoomLightbox('{{ Str::slug($groupName) }}')">
                                <div class="room-img-hover-overlay" onclick="openRoomLightbox('{{ Str::slug($groupName) }}')">
                                    <i class="bi bi-zoom-in"></i>
                                </div>
                                @if($roomImageCount > 1)
                                <button class="room-img-nav room-img-prev" onclick="event.stopPropagation(); changeRoomImage('{{ Str::slug($groupName) }}', -1)"><i class="bi bi-chevron-left"></i></button>
                                <button class="room-img-nav room-img-next" onclick="event.stopPropagation(); changeRoomImage('{{ Str::slug($groupName) }}', 1)"><i class="bi bi-chevron-right"></i></button>
                                <div class="room-img-dots">
                                    @for($di = 0; $di < $roomImageCount; $di++)
                                    <span class="dot {{ $di === 0 ? 'active' : '' }}" id="dot-{{ Str::slug($groupName) }}-{{ $di }}"></span>
                                    @endfor
                                </div>
                                @endif
                            </div>
                            <div class="room-quick-info mt-2">
                                <a href="#" class="text-primary small fw-medium">
                                    <i class="bi bi-images me-1"></i> {{ $roomImageCount }} photo{{ $roomImageCount > 1 ? 's' : '' }}
                                </a>
                                @if($roomSize)
                                <p class="small text-muted mb-1 mt-2">
                                    <i class="bi bi-arrows-fullscreen me-1"></i> {{ $roomSize }} m²
                                </p>
                                @endif
                                <p class="small text-muted mb-1">
                                    <i class="bi bi-house-door me-1"></i> {{ $bedType }}
                                </p>
                                @if($maxOccupancy)
                                <p class="small text-muted mb-1">
                                    <i class="bi bi-people me-1"></i> Max {{ $maxOccupancy }} guest{{ $maxOccupancy > 1 ? 's' : '' }}
                                </p>
                                @endif
                                @if($views && !is_array($views))
                                <p class="small text-muted mb-1">
                                    <i class="bi bi-eye me-1"></i> {{ $views }}
                                </p>
                                @endif
                                <p class="small text-muted mb-2">
                                    <i class="bi bi-credit-card me-1"></i> Pay with Card or Crypto
                                </p>
                                <hr>
                                <div class="room-amenities-list">
                                    @php
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
                                            <button class="btn btn-primary-custom btn-hover-glow text-white w-100 py-2 fw-semibold btn-book-now"
                                                data-room-id="{{ $room['roomId'] ?? '' }}"
                                                data-room-name="{{ $room['roomName'] ?? $groupName }}"
                                                data-room-type="{{ $groupName }}"
                                                data-bed-type="{{ $bedType ?? 'N/A' }}"
                                                data-price="{{ $room['rate']['inclusive'] ?? 0 }}"
                                                data-free-breakfast="{{ $room['freeBreakfast'] ? '1' : '0' }}"
                                                data-free-cancellation="{{ $room['freeCancellation'] ? '1' : '0' }}"
                                                data-cancellation-deadline="{{ $room['cancellationPolicy']['date'][0]['onward'] ?? '' }}"
                                                data-property-id="{{ $property['propertyId'] ?? '' }}"
                                                data-property-name="{{ $property['propertyName'] ?? '' }}"
                                                data-property-image="{{ $pictures[0]['URL'] ?? '' }}"
                                                data-check-in="{{ $checkIn ?? '' }}"
                                                data-check-out="{{ $checkOut ?? '' }}"
                                                data-rooms="{{ $rooms ?? 1 }}"
                                                data-adults="{{ $adults ?? 2 }}"
                                                data-children="{{ $children ?? 0 }}">
                                                Book Now <i class="bi bi-arrow-right ms-1"></i>
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
    {{-- <section class="py-5 bg-white">
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
    </section> --}}

    <!-- ============================
         Crypto Section
         ============================ -->
    {{-- <section class="crypto-section py-5">
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
    </section> --}}

    <!-- ============================
         Hotel Facilities
         ============================ -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="section-heading-row d-flex align-items-center gap-3 mb-4">
                <div class="section-heading-icon">
                    <i class="bi bi-building-check"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0" style="color: var(--primary-navy);">Hotel Facilities</h3>
                    <p class="text-muted small mb-0">Everything this property has to offer</p>
                </div>
            </div>
            @php
                $facilityGroups = collect($data['facilities']['facilities']['facility'] ?? [])->groupBy('property_group_description');
                $facilityGroupIcons = [
                    'Languages spoken' => 'bi-translate',
                    'Internet access' => 'bi-wifi',
                    'Internet' => 'bi-wifi',
                    'Things to do,

leisure and sports' => 'bi-trophy',
                    'Things to do' => 'bi-trophy',
                    'Cleanliness and safety' => 'bi-shield-check',
                    'Dining, drinking, and snacking' => 'bi-cup-hot',
                    'Dining' => 'bi-cup-hot',
                    'Services and conveniences' => 'bi-concierge-bell',
                    'Services' => 'bi-concierge-bell',
                    'For the kids' => 'bi-balloon',
                    'Access' => 'bi-universal-access',
                    'Getting around' => 'bi-car-front',
                    'Available in all rooms' => 'bi-door-open',
                    'Bathroom' => 'bi-droplet',
                    'Room amenities' => 'bi-lamp',
                    'Safety' => 'bi-shield-lock',
                    'Entertainment' => 'bi-music-note-beamed',
                    'Food and drinks' => 'bi-egg-fried',
                    'Outdoors' => 'bi-tree',
                    'Spa' => 'bi-droplet-half',
                    'Business' => 'bi-briefcase',
                    'General' => 'bi-grid',
                ];
                $facilityGroupColors = [
                    'Languages spoken' => '#6366f1',
                    'Internet access' => '#0ea5e9',
                    'Internet' => '#0ea5e9',
                    'Things to do, leisure and sports' => '#f59e0b',
                    'Things to do' => '#f59e0b',
                    'Cleanliness and safety' => '#10b981',
                    'Dining, drinking, and snacking' => '#ef4444',
                    'Dining' => '#ef4444',
                    'Services and conveniences' => '#8b5cf6',
                    'Services' => '#8b5cf6',
                    'For the kids' => '#ec4899',
                    'Access' => '#14b8a6',
                    'Getting around' => '#f97316',
                    'Available in all rooms' => '#1a237e',
                    'Bathroom' => '#06b6d4',
                    'Room amenities' => '#a855f7',
                    'Safety' => '#059669',
                    'Entertainment' => '#e11d48',
                    'Food and drinks' => '#ea580c',
                    'Outdoors' => '#16a34a',
                    'Spa' => '#0891b2',
                    'Business' => '#4f46e5',
                    'General' => '#64748b',
                ];
            @endphp
            <div class="row g-3">
                @foreach($facilityGroups as $groupName => $facilities)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="facility-card h-100">
                        <div class="facility-card-header">
                            <div class="facility-icon-badge" style="background: {{ $facilityGroupColors[$groupName] ?? '#64748b' }}15; color: {{ $facilityGroupColors[$groupName] ?? '#64748b' }};">
                                <i class="bi {{ $facilityGroupIcons[$groupName] ?? 'bi-check2-square' }}"></i>
                            </div>
                            <h6 class="facility-group-title">{{ $groupName }}</h6>
                            <span class="facility-count-badge">{{ count($facilities) }}</span>
                        </div>
                        <div class="facility-list">
                            @foreach($facilities as $fac)
                            <div class="facility-item">
                                <i class="bi bi-check2" style="color: {{ $facilityGroupColors[$groupName] ?? '#10b981' }};"></i>
                                <span>{{ $fac['property_translated_name'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================
         Nearby Places & Top Attractions
         ============================ -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="section-heading-row d-flex align-items-center gap-3 mb-4">
                <div class="section-heading-icon" style="background: linear-gradient(135deg, #0ea5e9, #6366f1);">
                    <i class="bi bi-pin-map-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0" style="color: var(--primary-navy);">What's Nearby</h3>
                    <p class="text-muted small mb-0">Explore the area around this property</p>
                </div>
            </div>
            <div class="row g-4">
                <!-- Top Attractions -->
                <div class="col-lg-4">
                    <div class="nearby-card h-100">
                        <div class="nearby-card-header" style="--nearby-accent: #f59e0b;">
                            <div class="nearby-header-icon">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Top Attractions</h6>
                                <small class="text-muted">Must-see places</small>
                            </div>
                        </div>
                        <div class="nearby-card-body">
                            @foreach(($data['information']['top_places']['top_place'] ?? []) as $place)
                            <div class="nearby-item">
                                <div class="nearby-item-dot" style="background: #f59e0b;"></div>
                                <div class="nearby-item-info">
                                    <span class="nearby-item-name">{{ $place['name'] }}</span>
                                    <div class="nearby-distance-row">
                                        <div class="nearby-distance-bar">
                                            <div class="nearby-distance-fill" style="width: {{ min(floatval($place['distance']) * 10, 100) }}%; background: linear-gradient(90deg, #f59e0b, #fbbf24);"></div>
                                        </div>
                                        <span class="nearby-distance-label">{{ $place['distance'] }} {{ $place['distance_unit'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Getting Around (Airports, Transport etc) -->
                <div class="col-lg-4">
                    <div class="nearby-card h-100">
                        <div class="nearby-card-header" style="--nearby-accent: #4267B2;">
                            <div class="nearby-header-icon">
                                <i class="bi bi-airplane-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Getting Around</h6>
                                <small class="text-muted">Transport & access</small>
                            </div>
                        </div>
                        <div class="nearby-card-body">
                            @foreach(($data['information']['nearby_properties']['nearby_property'] ?? []) as $np)
                            <div class="nearby-item">
                                <div class="nearby-item-dot" style="background: #4267B2;"></div>
                                <div class="nearby-item-info">
                                    <span class="nearby-item-name">{{ $np['name'] }}</span>
                                    <span class="nearby-item-category">{{ $np['category_name'] }}</span>
                                    <div class="nearby-distance-row">
                                        <div class="nearby-distance-bar">
                                            <div class="nearby-distance-fill" style="width: {{ min(floatval($np['distance']) * 3, 100) }}%; background: linear-gradient(90deg, #4267B2, #6b8dd6);"></div>
                                        </div>
                                        <span class="nearby-distance-label">{{ $np['distance'] }} {{ $np['distance_unit'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Nearby Places -->
                <div class="col-lg-4">
                    <div class="nearby-card h-100">
                        <div class="nearby-card-header" style="--nearby-accent: #10b981;">
                            <div class="nearby-header-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Nearby Places</h6>
                                <small class="text-muted">Shopping & dining</small>
                            </div>
                        </div>
                        <div class="nearby-card-body">
                            @foreach(($data['information']['nearby_places']['nearby_place'] ?? []) as $np)
                            <div class="nearby-item">
                                <div class="nearby-item-dot" style="background: #10b981;"></div>
                                <div class="nearby-item-info">
                                    <span class="nearby-item-name">{{ $np['name'] }}</span>
                                    <div class="nearby-distance-row">
                                        <div class="nearby-distance-bar">
                                            <div class="nearby-distance-fill" style="width: {{ min(floatval($np['distance']) * 10, 100) }}%; background: linear-gradient(90deg, #10b981, #34d399);"></div>
                                        </div>
                                        <span class="nearby-distance-label">{{ $np['distance'] }} {{ $np['distance_unit'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
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
                <h3 class="fw-bold mb-4">About {{ $property['propertyName'] ?? 'This Hotel' }}</h3>
                <p class="text-muted small">
                    {{ $property['propertyName'] ?? 'This hotel' }} is a centrally located property offering excellent amenities
                    and convenient access to local attractions. The property features comfortable rooms with modern furnishings,
                    complimentary high-speed internet, and a selection of dining options. Guests enjoy premium amenities including
                    a fitness center, and attentive customer service to ensure a pleasant stay.
                </p>

                <div class="mt-4">
                    <h5 class="fw-bold mb-3">You need to know</h5>
                    <ul class="hotel-info-list">
                        <li class="small text-muted">Cashless payment methods are available for all transactions at this property.</li>
                        <li class="small text-muted">Government-issued photo identification and a credit card, debit card, or cash deposit may be required at check-in for incidental charges.</li>
                        <li class="small text-muted">This property welcomes guests of all sexual orientations and gender identities (LGBTQ+ friendly).</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery & Lightbox JS -->
    <script>
        // All pictures data for the main gallery lightbox
        const allPictures = @json($pictures);
        let currentLightboxIndex = 0;
        let lightboxMode = 'gallery'; // 'gallery' or 'room'
        let roomLightboxImages = [];

        function openLightbox(index) {
            lightboxMode = 'gallery';
            currentLightboxIndex = index;
            showLightboxImage();
        }

        function showLightboxImage() {
            const backdrop = document.getElementById('lightboxBackdrop');
            const img = document.getElementById('lightboxImg');
            const caption = document.getElementById('lightboxCaption');
            const counter = document.getElementById('lightboxCounter');

            if (lightboxMode === 'gallery') {
                const pic = allPictures[currentLightboxIndex];
                img.src = pic.URL;
                const cap = (Array.isArray(pic.caption) || !pic.caption) ? '' : pic.caption;
                caption.textContent = cap;
                caption.style.display = cap ? 'block' : 'none';
                counter.textContent = (currentLightboxIndex + 1) + ' / ' + allPictures.length;
            } else {
                img.src = roomLightboxImages[currentLightboxIndex];
                caption.style.display = 'none';
                counter.textContent = (currentLightboxIndex + 1) + ' / ' + roomLightboxImages.length;
            }

            backdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightboxBackdrop').classList.remove('active');
            document.body.style.overflow = '';
        }

        function navigateLightbox(dir) {
            const total = lightboxMode === 'gallery' ? allPictures.length : roomLightboxImages.length;
            currentLightboxIndex += dir;
            if (currentLightboxIndex < 0) currentLightboxIndex = total - 1;
            if (currentLightboxIndex >= total) currentLightboxIndex = 0;
            showLightboxImage();
        }

        // Keyboard nav
        document.addEventListener('keydown', function(e) {
            if (!document.getElementById('lightboxBackdrop').classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') navigateLightbox(-1);
            if (e.key === 'ArrowRight') navigateLightbox(1);
        });

        // Room image carousel
        function changeRoomImage(slug, direction) {
            const carousel = document.getElementById('roomCarousel-' + slug);
            const img = document.getElementById('roomImg-' + slug);
            const images = JSON.parse(carousel.getAttribute('data-images'));
            let index = parseInt(carousel.getAttribute('data-index'));

            index += direction;
            if (index < 0) index = images.length - 1;
            if (index >= images.length) index = 0;

            img.src = images[index];
            carousel.setAttribute('data-index', index);

            const dots = carousel.querySelectorAll('.dot');
            dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
        }

        // Room image click -> open lightbox with room photos
        function openRoomLightbox(slug) {
            const carousel = document.getElementById('roomCarousel-' + slug);
            roomLightboxImages = JSON.parse(carousel.getAttribute('data-images'));
            currentLightboxIndex = parseInt(carousel.getAttribute('data-index'));
            lightboxMode = 'room';
            showLightboxImage();
        }

        // ========================
        // Booking Modal Logic
        // ========================
        document.querySelectorAll('.btn-book-now').forEach(btn => {
            btn.addEventListener('click', function() {
                const data = this.dataset;
                const checkIn = new Date(data.checkIn);
                const checkOut = new Date(data.checkOut);
                const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
                const pricePerNight = parseFloat(data.price);
                const totalPrice = pricePerNight * nights;
                const rooms = parseInt(data.rooms);

                // Populate modal fields
                document.getElementById('modalPropertyName').textContent = data.propertyName;
                document.getElementById('modalRoomName').textContent = data.roomName;
                document.getElementById('modalCheckIn').textContent = checkIn.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                document.getElementById('modalCheckOut').textContent = checkOut.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                document.getElementById('modalNights').textContent = nights + ' night' + (nights > 1 ? 's' : '');
                document.getElementById('modalNightsSummary').textContent = nights + ' night' + (nights > 1 ? 's' : '');
                document.getElementById('modalGuests').textContent = data.adults + ' adult' + (parseInt(data.adults) > 1 ? 's' : '') + ', ' + rooms + ' room' + (rooms > 1 ? 's' : '');
                document.getElementById('modalPricePerNight').textContent = 'US$' + pricePerNight.toFixed(2);
                document.getElementById('modalTotalPrice').textContent = 'US$' + totalPrice.toFixed(2);
                document.getElementById('modalPayAtHotelTotal').textContent = 'US$' + totalPrice.toFixed(2);
                document.getElementById('modalPayNowTotal').textContent = 'US$' + totalPrice.toFixed(2);
                document.getElementById('modalPropertyImg').src = data.propertyImage || '{{ asset("assets/images/login-1.jpg") }}';

                const breakfastBadge = document.getElementById('modalBreakfast');
                breakfastBadge.style.display = data.freeBreakfast === '1' ? 'inline-flex' : 'none';

                const cancellationBadge = document.getElementById('modalCancellation');
                if (data.freeCancellation === '1') {
                    cancellationBadge.textContent = 'Free Cancellation';
                    cancellationBadge.className = 'badge bg-success-subtle text-success';
                } else {
                    cancellationBadge.textContent = 'Non-refundable';
                    cancellationBadge.className = 'badge bg-danger-subtle text-danger';
                }

                // Set hidden form values
                document.getElementById('formPropertyId').value = data.propertyId;
                document.getElementById('formPropertyName').value = data.propertyName;
                document.getElementById('formPropertyImage').value = data.propertyImage;
                document.getElementById('formRoomId').value = data.roomId;
                document.getElementById('formRoomName').value = data.roomName;
                document.getElementById('formRoomType').value = data.roomType;
                document.getElementById('formBedType').value = data.bedType;
                document.getElementById('formCheckIn').value = data.checkIn;
                document.getElementById('formCheckOut').value = data.checkOut;
                document.getElementById('formRooms').value = data.rooms;
                document.getElementById('formAdults').value = data.adults;
                document.getElementById('formChildren').value = data.children;
                document.getElementById('formPricePerNight').value = pricePerNight;
                document.getElementById('formTotalPrice').value = totalPrice;
                document.getElementById('formFreeCancellation').value = data.freeCancellation;
                document.getElementById('formCancellationDeadline').value = data.cancellationDeadline;
                document.getElementById('formFreeBreakfast').value = data.freeBreakfast;

                selectPaymentType('pay_now');

                const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
                modal.show();
            });
        });

        function selectPaymentType(type) {
            document.querySelectorAll('.payment-option-card').forEach(card => {
                card.classList.remove('selected');
            });
            document.getElementById('payOption_' + type).classList.add('selected');
            document.getElementById('formPaymentType').value = type;
        }
    </script>

    <!-- ============================
         Booking Modal
         ============================ -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content booking-modal-content">
                <div class="modal-header booking-modal-header">
                    <div>
                        <h5 class="modal-title fw-bold" id="bookingModalLabel">
                            <i class="bi bi-calendar-check me-2"></i>Confirm Your Stay
                        </h5>
                        <p class="text-muted small mb-0">Review your booking details before proceeding</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- Booking Summary -->
                    <div class="booking-modal-summary">
                        <div class="d-flex gap-3">
                            <div class="booking-modal-thumb">
                                <img id="modalPropertyImg" src="" alt="Property">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1" id="modalPropertyName"></h6>
                                <p class="small text-muted mb-1" id="modalRoomName"></p>
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <span class="badge bg-primary-subtle text-primary" id="modalBreakfast">
                                        <i class="bi bi-cup-hot me-1"></i>Breakfast Included
                                    </span>
                                    <span class="badge" id="modalCancellation">Free Cancellation</span>
                                </div>
                                <div class="d-flex gap-4 text-muted small">
                                    <span><i class="bi bi-box-arrow-in-right me-1"></i><span id="modalCheckIn"></span></span>
                                    <span><i class="bi bi-box-arrow-right me-1"></i><span id="modalCheckOut"></span></span>
                                </div>
                                <div class="d-flex gap-4 text-muted small mt-1">
                                    <span><i class="bi bi-moon me-1"></i><span id="modalNights"></span></span>
                                    <span><i class="bi bi-people me-1"></i><span id="modalGuests"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Options -->
                    <div class="booking-modal-options">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-wallet2 me-2"></i>Choose Payment Option
                        </h6>

                        <!-- Pay at Hotel -->
                        <div class="payment-option-card" id="payOption_pay_at_hotel" onclick="selectPaymentType('pay_at_hotel')">
                            <div class="d-flex align-items-start gap-3">
                                <div class="payment-option-radio">
                                    <div class="radio-dot"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="fw-bold mb-1">Pay when you stay</h6>
                                            <p class="small text-muted mb-0">No upfront payment needed. Pay directly at the hotel during check-in.</p>
                                        </div>
                                        <span class="payment-option-price" id="modalPayAtHotelTotal">US$0.00</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="badge bg-warning-subtle text-warning"><i class="bi bi-clock me-1"></i>Reserve now, pay later</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pay Now -->
                        <div class="payment-option-card selected" id="payOption_pay_now" onclick="selectPaymentType('pay_now')">
                            <div class="d-flex align-items-start gap-3">
                                <div class="payment-option-radio">
                                    <div class="radio-dot"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="fw-bold mb-1">Pay the total now</h6>
                                            <p class="small text-muted mb-0">Secure your booking with instant payment via crypto or card.</p>
                                        </div>
                                        <span class="payment-option-price" id="modalPayNowTotal">US$0.00</span>
                                    </div>
                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-shield-check me-1"></i>Instant Confirmation</span>
                                        <span class="badge bg-info-subtle text-info"><i class="bi bi-currency-bitcoin me-1"></i>Crypto Accepted</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="booking-modal-price">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Price per night</span>
                            <span class="small fw-medium" id="modalPricePerNight">US$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Duration</span>
                            <span class="small fw-medium" id="modalNightsSummary"></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold" id="modalTotalPrice" style="font-size: 1.2rem; color: var(--primary-navy);">US$0.00</span>
                        </div>
                        <small class="text-muted d-block mt-1">Including taxes and fees</small>
                    </div>
                </div>

                <div class="modal-footer booking-modal-footer">
                    <form action="{{ route('booking.store') }}" method="POST" class="w-100">
                        @csrf
                        <input type="hidden" name="property_id" id="formPropertyId">
                        <input type="hidden" name="property_name" id="formPropertyName">
                        <input type="hidden" name="property_image" id="formPropertyImage">
                        <input type="hidden" name="room_id" id="formRoomId">
                        <input type="hidden" name="room_name" id="formRoomName">
                        <input type="hidden" name="room_type" id="formRoomType">
                        <input type="hidden" name="bed_type" id="formBedType">
                        <input type="hidden" name="check_in" id="formCheckIn">
                        <input type="hidden" name="check_out" id="formCheckOut">
                        <input type="hidden" name="rooms" id="formRooms">
                        <input type="hidden" name="adults" id="formAdults">
                        <input type="hidden" name="children" id="formChildren">
                        <input type="hidden" name="price_per_night" id="formPricePerNight">
                        <input type="hidden" name="total_price" id="formTotalPrice">
                        <input type="hidden" name="free_cancellation" id="formFreeCancellation">
                        <input type="hidden" name="cancellation_deadline" id="formCancellationDeadline">
                        <input type="hidden" name="free_breakfast" id="formFreeBreakfast">
                        <input type="hidden" name="payment_type" id="formPaymentType" value="pay_now">

                        <button type="submit" class="btn btn-primary-custom btn-hover-glow text-white w-100 py-3 fw-bold" style="font-size: 1.05rem;">
                            <i class="bi bi-lock me-2"></i>Proceed to Checkout
                        </button>
                    </form>
                    <p class="text-center text-muted small mt-2 mb-0 w-100">
                        <i class="bi bi-shield-lock me-1"></i>Your payment information is secure and encrypted
                    </p>
                </div>
            </div>
        </div>
    </div>

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