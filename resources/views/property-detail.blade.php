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

    @php
        $hotelInfo = $data['information']['hotel'] ?? [];
        $hotelDescription = $data['descriptions']['hotel_description']['overview'] ?? null;
        $hotelRemark = $hotelInfo['remark'] ?? null;
        $childPolicy = $hotelInfo['child_and_extra_bed_policy'] ?? [];
        $hasChildPolicy = !empty($childPolicy);
        $addressList = $data['addresses']['address'] ?? [];
        $roomsForPolicy = collect($groupedRooms ?? [])->flatMap(fn($group) => $group['rooms'] ?? []);
        if ($roomsForPolicy->isEmpty()) {
            $roomsForPolicy = collect($property['rooms'] ?? []);
        }
        $firstPolicyRoom = $roomsForPolicy->first(function ($room) {
            return !empty($room['cancellationPolicy']['translatedCancellationText'])
                || !empty($room['cancellationPolicy']['cancellationText']);
        });
        $cancellationText = $firstPolicyRoom['cancellationPolicy']['translatedCancellationText']
            ?? $firstPolicyRoom['cancellationPolicy']['cancellationText']
            ?? null;
        $hasFreeCancellation = $roomsForPolicy->contains(fn($room) => (bool)($room['freeCancellation'] ?? false));
        $firstFreeCancellationRoom = $roomsForPolicy->first(fn($room) => (bool)($room['freeCancellation'] ?? false));
        $freeCancellationDeadline = $firstFreeCancellationRoom['cancellationPolicy']['date'][0]['onward'] ?? null;

        if (isset($addressList['address_type'])) {
            $addressList = [$addressList];
        }
        $primaryAddress = collect($addressList)->firstWhere('address_type', 'English address') ?? ($addressList[0] ?? null);
    @endphp

    <section class="pb-4">
        <div class="container">
            <div class="property-info-card p-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; box-shadow: 0 8px 22px rgba(15, 23, 42, 0.04);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: #f3f4f6; color: #334155;">
                            <i class="bi bi-building-check"></i>
                        </div>
                        <h5 class="fw-bold mb-0" style="color: #0f172a;">About This Property</h5>
                    </div>
                    <div class="d-flex align-items-center gap-2 small text-muted">
                        @if(!empty($hotelInfo['rating_average']))
                        <span class="badge rounded-pill" style="background:#e2e8f0; color:#0f172a;">{{ $hotelInfo['rating_average'] }}</span>
                        @endif
                        @if(!empty($hotelInfo['number_of_reviews']))
                        <span>{{ number_format((int) $hotelInfo['number_of_reviews']) }} reviews</span>
                        @endif
                    </div>
                </div>

                @if($primaryAddress)
                <div class="rounded-3 px-3 py-2 mb-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill mt-1" style="color:#64748b;"></i>
                        <div>
                            <span class="fw-semibold" style="color:#334155;">Address</span>
                            <p class="mb-0 text-muted small">
                                {{ $primaryAddress['address_line_1'] ?? '' }}
                                @if(!empty($primaryAddress['address_line_2']) && !is_array($primaryAddress['address_line_2']))
                                , {{ $primaryAddress['address_line_2'] }}
                                @endif
                                , {{ $primaryAddress['city'] ?? '' }}
                                @if(!empty($primaryAddress['state']))
                                , {{ $primaryAddress['state'] }}
                                @endif
                                @if(!empty($primaryAddress['postal_code']))
                                {{ $primaryAddress['postal_code'] }}
                                @endif
                                @if(!empty($primaryAddress['country']))
                                , {{ $primaryAddress['country'] }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                @if($hotelRemark || $hotelDescription || $cancellationText || $hasFreeCancellation || $hasChildPolicy)
                <div class="accordion" id="aboutPropertyAccordion">
                    @if($hotelRemark)
                    <div class="accordion-item rounded-3 mb-2 overflow-hidden p-2" style="border:1px solid #e2e8f0; box-shadow:none;">
                        <h2 class="accordion-header" id="aboutPropertyRemarkHeading">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#aboutPropertyRemark" aria-expanded="true" aria-controls="aboutPropertyRemark" style="background:#f8fafc; color:#0f172a; box-shadow:none;">
                                <i class="bi bi-exclamation-circle-fill me-2"></i> Important Remark
                            </button>
                        </h2>
                        <div id="aboutPropertyRemark" class="accordion-collapse collapse show" aria-labelledby="aboutPropertyRemarkHeading" data-bs-parent="#aboutPropertyAccordion">
                            <div class="accordion-body text-muted py-3" style="background:#ffffff; line-height:1.7;">
                                {{ $hotelRemark }}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($cancellationText || $hasFreeCancellation)
                    <div class="accordion-item rounded-3 mb-2 overflow-hidden p-2" style="border:1px solid #e2e8f0; box-shadow:none;">
                        <h2 class="accordion-header" id="aboutPropertyCancellationHeading">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#aboutPropertyCancellation" aria-expanded="false" aria-controls="aboutPropertyCancellation" style="background:#f8fafc; color:#0f172a; box-shadow:none;">
                                <i class="bi bi-shield-check me-2"></i> Cancellation Policy
                            </button>
                        </h2>
                        <div id="aboutPropertyCancellation" class="accordion-collapse collapse" aria-labelledby="aboutPropertyCancellationHeading" data-bs-parent="#aboutPropertyAccordion">
                            <div class="accordion-body text-muted py-3" style="background:#ffffff; line-height:1.7;">
                                @if($hasFreeCancellation && $freeCancellationDeadline)
                                <p class="mb-2">
                                    <span class="badge rounded-pill" style="background:#e2e8f0; color:#0f172a;">Free Cancellation</span>
                                    <span class="ms-2">Until {{ \Carbon\Carbon::parse($freeCancellationDeadline)->format('M d, Y') }}</span>
                                </p>
                                @elseif($hasFreeCancellation)
                                <p class="mb-2"><span class="badge rounded-pill" style="background:#e2e8f0; color:#0f172a;">Free Cancellation Available</span></p>
                                @endif

                                @if($cancellationText)
                                <p class="mb-0">{{ $cancellationText }}</p>
                                @else
                                <p class="mb-0">Please check the selected room policy before booking.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($hasChildPolicy)
                    <div class="accordion-item rounded-3 mb-2 overflow-hidden p-2" style="border:1px solid #e2e8f0; box-shadow:none;">
                        <h2 class="accordion-header" id="aboutPropertyChildPolicyHeading">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#aboutPropertyChildPolicy" aria-expanded="false" aria-controls="aboutPropertyChildPolicy" style="background:#f8fafc; color:#0f172a; box-shadow:none;">
                                <i class="bi bi-people me-2"></i> Child & Extra Bed Policy
                            </button>
                        </h2>
                        <div id="aboutPropertyChildPolicy" class="accordion-collapse collapse" aria-labelledby="aboutPropertyChildPolicyHeading" data-bs-parent="#aboutPropertyAccordion">
                            <div class="accordion-body text-muted py-3" style="background:#ffffff; line-height:1.7;">
                                <ul class="mb-0 ps-3">
                                    @php
                                        $true = 'Acknowledge *<br> Please note that children will not be provided with an extra bed, and meals are not included. Any requested meals must be paid for directly to the hotel. Ensure your customers are informed of these conditions.';
                                    @endphp
                                    <li>Infant age: {{ $childPolicy['infant_age'] ?? 'N/A' }}</li>
                                    <li>Children age range: {{ $childPolicy['children_age_from'] ?? 'N/A' }} to {{ $childPolicy['children_age_to'] ?? 'N/A' }}</li>
                                    <li>Children stay free: {!! (($childPolicy['children_stay_free'] ?? 'false') === 'true' || ($childPolicy['children_stay_free'] ?? false) === true) ? $true : 'No' !!}</li>
                                    <li>Minimum guest age: {{ $childPolicy['min_guest_age'] ?? 'N/A' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($hotelDescription)
                    <div class="accordion-item rounded-3 overflow-hidden p-2" style="border:1px solid #e2e8f0; box-shadow:none;">
                        <h2 class="accordion-header" id="aboutPropertyDescriptionHeading">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#aboutPropertyDescription" aria-expanded="false" aria-controls="aboutPropertyDescription" style="background:#f8fafc; color:#0f172a; box-shadow:none;">
                                <i class="bi bi-card-text me-2"></i> Property Description
                            </button>
                        </h2>
                        <div id="aboutPropertyDescription" class="accordion-collapse collapse" aria-labelledby="aboutPropertyDescriptionHeading" data-bs-parent="#aboutPropertyAccordion">
                            <div class="accordion-body text-muted py-3" style="background:#ffffff; line-height:1.7;">
                                {{ $hotelDescription }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>

    @if(!empty($allBenefits ?? []))
    <section class="pb-4">
        <div class="container">
            <div class="property-info-card p-3" style="background:#ffffff; border:1px solid #e5e7eb; border-radius:14px;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-stars" style="color:#334155;"></i>
                    <h6 class="fw-bold mb-0" style="color:#0f172a;">Property Benefits</h6>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($allBenefits as $benefit)
                    <span class="badge rounded-pill px-3 py-2" style="background:#f1f5f9; color:#334155; border:1px solid #e2e8f0; font-weight:500;">
                        <i class="bi bi-check2-circle me-1"></i>{{ $benefit['name'] }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

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
                <div class="amenity-chip" title="{{ $facility['property_translated_name'] }}" data-facility-name="{{ $facility['property_name'] }}" data-facility-group="{{ $facility['property_group_description'] }}" onclick="toggleAmenityFilter(this)">
                    <i class="bi {{ $iconMap[$facility['property_name']] ?? 'bi-check-circle' }}"></i>
                    <span class="amenity-chip-label">{{ $facility['property_translated_name'] }}</span>
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
                {{-- <div class="room-filters d-flex flex-wrap gap-2 mt-3">
                    <button class="room-filter-pill" data-filter="breakfast" onclick="toggleRoomFilter(this)">
                        <i class="bi bi-cup-hot-fill me-1"></i> Breakfast Included
                    </button>
                    <button class="room-filter-pill" data-filter="cancellation" onclick="toggleRoomFilter(this)">Free Cancellation</button>
                    <button class="room-filter-pill" data-filter="non-smoking" onclick="toggleRoomFilter(this)">Non-smoking</button>
                    <button class="room-filter-pill" data-filter="twin" onclick="toggleRoomFilter(this)">Twin</button>
                    <button class="room-filter-pill" data-filter="premium" onclick="toggleRoomFilter(this)">Premium</button>
                </div> --}}
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

                // Collect all benefit names from all rooms in this group (lowercased for matching)
                $allBenefitNames = collect($group['rooms'])
                    ->flatMap(fn($r) => collect($r['benefits'] ?? [])->pluck('translatedBenefitName'))
                    ->map(fn($b) => strtolower($b))
                    ->unique()
                    ->values()
                    ->toArray();
            @endphp
            <div class="room-type-card mb-4" data-room-benefits='@json($allBenefitNames)'>
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
                            <div class="rate-option-row"
                                data-has-breakfast="{{ $room['freeBreakfast'] ? '1' : '0' }}"
                                data-has-cancellation="{{ $room['freeCancellation'] ? '1' : '0' }}"
                                data-room-name="{{ strtolower($room['roomName'] ?? $groupName) }}">
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
                                                {{ $room['cancellationPolicy']['translatedCancellationText'] ?? '' }}
                                                {{-- @if($room['freeCancellation'])
                                                    Free cancellation until {{ \Carbon\Carbon::parse($room['cancellationPolicy']['date'][0]['onward'] ?? '')->format('M d, Y') }}
                                                @else
                                                    Non-refundable
                                                @endif --}}
                                            </p>
                                            @endif

                                            
                                            <p class="small text-muted mb-1" style="font-size: 0.72rem;">
                                                <i class="bi bi-people me-1"></i> {{ $rooms }} room, {{ $adults }} adults
                                            </p>
                                            <p class="small text-muted mb-1" style="font-size: 0.72rem;">
                                                <i class="bi bi-plus-square me-1"></i>
                                                {{ (int) ($room['extraBeds'] ?? 0) }} extra bed{{ ((int) ($room['extraBeds'] ?? 0)) === 1 ? '' : 's' }}
                                            </p>
                                            <p class="small text-muted mb-0" style="font-size: 0.72rem;">
                                                <i class="bi bi-credit-card me-1"></i> Pay with Card or Crypto
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-4">
                                        @php
                                            $_rateTax        = (float)($room['rate']['tax'] ?? 0);
                                            $_rateFees       = (float)($room['rate']['fees'] ?? 0);
                                            $_rateExcl       = (float)($room['rate']['exclusive'] ?? 0);
                                            $_inclSurcharges = collect($room['surcharges'] ?? [])->filter(fn($s) => ($s['charge'] ?? '') === 'Included');
                                            $_payAtHotel     = collect($room['surcharges'] ?? [])->filter(fn($s) => in_array($s['charge'] ?? '', ['Excluded', 'Mandatory']));
                                        @endphp
                                        <div class="rate-price p-3">
                                            <!-- ── Paid Online ── -->
                                            <div class="text-end">
                                                <div class="d-flex align-items-center justify-content-end gap-1 mb-1">
                                                    <span class="badge rounded-pill" style="background:#e0f2fe; color:#0369a1; font-size:0.6rem; font-weight:600;">PAID ONLINE</span>
                                                </div>
                                                <span class="rate-price-amount">US${{ number_format($room['rate']['inclusive'] ?? 0, 2) }}</span>
                                                <small class="d-block text-muted" style="font-size: 0.68rem;">Per night · {{ $rooms }} room · incl. taxes &amp; fees</small>
                                            </div>

                                            <!-- ── Online price breakdown ── -->
                                            @if($_rateExcl > 0 || $_rateTax > 0 || $_rateFees > 0 || $_inclSurcharges->count() > 0)
                                            <div class="mt-2 pt-2" style="border-top:1px solid #e5e7eb;">
                                                @if($_rateExcl > 0)
                                                <div class="d-flex justify-content-between">
                                                    <small style="font-size:0.65rem; color:#94a3b8;">Room rate</small>
                                                    <small style="font-size:0.65rem; color:#94a3b8;">US${{ number_format($_rateExcl, 2) }}</small>
                                                </div>
                                                @endif
                                                @if($_rateTax > 0)
                                                <div class="d-flex justify-content-between">
                                                    <small style="font-size:0.65rem; color:#94a3b8;">Taxes</small>
                                                    <small style="font-size:0.65rem; color:#94a3b8;">US${{ number_format($_rateTax, 2) }}</small>
                                                </div>
                                                @endif
                                                @if($_rateFees > 0)
                                                <div class="d-flex justify-content-between">
                                                    <small style="font-size:0.65rem; color:#94a3b8;">Fees</small>
                                                    <small style="font-size:0.65rem; color:#94a3b8;">US${{ number_format($_rateFees, 2) }}</small>
                                                </div>
                                                @endif
                                                @foreach($_inclSurcharges as $_s)
                                                <div class="d-flex justify-content-between">
                                                    <small style="font-size:0.65rem; color:#94a3b8;">{{ $_s['name'] ?? 'Surcharge' }}</small>
                                                    <small style="font-size:0.65rem; color:#94a3b8;">US${{ number_format((float)($_s['rate']['inclusive'] ?? 0), 2) }}</small>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif

                                            <!-- ── Pay at Hotel ── -->
                                            @if($_payAtHotel->count() > 0)
                                            <div class="mt-2 pt-2 px-2 pb-2 rounded-2" style="background:#fff8e1; border:1px solid #fde68a; border-top:2px solid #f59e0b;">
                                                <div class="d-flex align-items-center gap-1 mb-1">
                                                    <i class="bi bi-building" style="font-size:0.72rem; color:#d97706;"></i>
                                                    <span class="fw-bold" style="font-size:0.7rem; color:#92400e; letter-spacing:.02em;">PAY AT HOTEL</span>
                                                    <span class="ms-auto" style="font-size:0.6rem; color:#b45309;">Not included in total</span>
                                                </div>
                                                @foreach($_payAtHotel as $_ph)
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small style="font-size:0.65rem; color:#92400e;">
                                                        <i class="bi bi-dot"></i>{{ $_ph['name'] ?? 'Hotel fee' }}
                                                    </small>
                                                    <small style="font-size:0.65rem; color:#92400e; font-weight:600;">
                                                        {{ (float)($_ph['rate']['inclusive'] ?? 0) > 0 ? 'US$'.number_format((float)$_ph['rate']['inclusive'], 2) : 'Varies' }}
                                                    </small>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif

                                            @if(isset($room['promotionDetail']['savingAmount']))
                                            <div class="rate-promo-tag mt-2 text-end">
                                                <small style="font-size: 0.65rem;">
                                                    Approx. <strong>US${{ number_format($room['promotionDetail']['savingAmount'], 0) }}</strong> AVA payback with
                                                    <span class="text-decoration-underline">FREE Smart membership</span>
                                                </small>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Book Button -->
                                    <div class="col-md-3">
                                        <div class="rate-action p-3 text-center">
                                            @php
                                                // Only sum INCLUDED surcharges — excluded/mandatory are NOT part of online total
                                                $roomSurchargeTotal = collect($room['surcharges'] ?? [])
                                                    ->filter(fn($s) => ($s['charge'] ?? '') === 'Included')
                                                    ->sum(fn($s) => (float)($s['rate']['inclusive'] ?? 0));
                                            @endphp
                                            @php
                                                $roomBenefitsList = collect($room['benefits'] ?? [])->map(fn($b) => $b['translatedBenefitName'] ?? $b['benefitName'] ?? '')->filter()->values()->toArray();
                                                $roomSurchargesList = collect($room['surcharges'] ?? [])->map(function($s) {
                                                    return [
                                                        'name'   => $s['name'] ?? $s['description'] ?? 'Surcharge',
                                                        'amount' => (float)($s['rate']['inclusive'] ?? 0),
                                                        'type'   => $s['charge'] ?? 'Included', // Included | Excluded | Mandatory
                                                    ];
                                                })->toArray();
                                                $roomCancellationText = $room['cancellationPolicy']['translatedCancellationText']
                                                    ?? $room['cancellationPolicy']['cancellationText']
                                                    ?? '';
                                            @endphp
                                            <button class="btn btn-primary-custom btn-hover-glow text-white w-100 py-2 fw-semibold btn-book-now"
                                                data-room-id="{{ $room['roomId'] ?? '' }}"
                                                data-room-name="{{ $room['roomName'] ?? $groupName }}"
                                                data-block-id="{{ $room['blockId'] ?? '' }}"
                                                data-room-type="{{ $groupName }}"
                                                data-bed-type="{{ $bedType ?? 'N/A' }}"
                                                data-price="{{ $room['rate']['inclusive'] ?? 0 }}"
                                                data-rate-exclusive="{{ $room['rate']['exclusive'] ?? 0 }}"
                                                data-rate-tax="{{ $room['rate']['tax'] ?? 0 }}"
                                                data-rate-fees="{{ $room['rate']['fees'] ?? 0 }}"
                                                data-surcharge-amount="{{ $roomSurchargeTotal }}"
                                                data-rate-currency="{{ $room['rate']['currency'] ?? 'USD' }}"
                                                data-rate-method="{{ $room['rate']['method'] ?? 'PRPN' }}"
                                                data-payment-model="{{ $room['paymentModel'] ?? 'Merchant' }}"
                                                data-free-breakfast="{{ $room['freeBreakfast'] ? '1' : '0' }}"
                                                data-free-cancellation="{{ $room['freeCancellation'] ? '1' : '0' }}"
                                                data-cancellation-deadline="{{ $room['cancellationPolicy']['date'][0]['onward'] ?? '' }}"
                                                data-property-id="{{ $property['propertyId'] ?? '' }}"
                                                data-property-name="{{ $property['propertyName'] ?? '' }}"
                                                data-property-image="{{ $mainRoomImage }}"
                                                data-check-in="{{ $checkIn ?? '' }}"
                                                data-check-out="{{ $checkOut ?? '' }}"
                                                data-rooms="{{ $rooms ?? 1 }}"
                                                data-adults="{{ $adults ?? 2 }}"
                                                data-children="{{ $children ?? 0 }}"
                                                data-benefits='@json($roomBenefitsList)'
                                                data-surcharges='@json($roomSurchargesList)'
                                                data-surcharges-raw='@json($room['surcharges'] ?? [])'
                                                data-cancellation-policy="{{ $roomCancellationText }}"
                                                data-hotel-remarks="{{ $hotelRemark ?? '' }}"
                                                data-hotel-address="{{ $primaryAddress ? trim(($primaryAddress['address_line_1'] ?? '') . ', ' . ($primaryAddress['city'] ?? '') . ', ' . ($primaryAddress['country'] ?? '')) : '' }}">
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

            <!-- No rooms match message -->
            <div class="no-rooms-message d-none" id="noRoomsMessage">
                <div class="text-center py-5">
                    <i class="bi bi-search" style="font-size: 2.5rem; color: #ccc;"></i>
                    <h5 class="mt-3 text-muted">No rooms available for this filter</h5>
                    <p class="text-muted small">Try removing some filters to see more rooms</p>
                    <button class="btn btn-outline-primary mt-2" onclick="clearAllFilters()">Clear All Filters</button>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         Customer Reviews
         ============================ -->

    <!-- ============================
         Hotel Facilities
         ============================ -->
    <section class="py-5 bg-light" id="facilities-section">
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
                <div class="col-md-6 col-lg-4 col-xl-3 facility-group-col" data-group-name="{{ $groupName }}">
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
                            <div class="facility-item" data-facility-name="{{ $fac['property_name'] }}">
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
    {{-- <section class="py-5 bg-white">
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
    </section> --}}

    <!-- Gallery & Lightbox JS -->
    <script>
        // ========================
        // Amenity Filter Logic
        // ========================
        let activeFilters = new Set();

        function toggleAmenityFilter(el) {
            const facilityName = el.getAttribute('data-facility-name');
            const facilityGroup = el.getAttribute('data-facility-group');

            el.classList.toggle('active');

            if (activeFilters.has(facilityName)) {
                activeFilters.delete(facilityName);
            } else {
                activeFilters.add(facilityName);
            }

            applyAllFilters();

            // Scroll to rooms section when first filter is activated
            if (activeFilters.size === 1 && el.classList.contains('active')) {
                const section = document.getElementById('rooms-section');
                if (section) {
                    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }

        function applyFacilityFilter() {
            const allCols = document.querySelectorAll('.facility-group-col');
            const allItems = document.querySelectorAll('.facility-item');

            // Clear all highlights and dims
            allItems.forEach(item => item.classList.remove('highlighted'));
            allCols.forEach(col => col.classList.remove('dimmed'));

            // Room filtering
            const roomCards = document.querySelectorAll('.room-type-card');

            if (activeFilters.size === 0) {
                // No amenity filters active — show all room cards
                roomCards.forEach(card => card.style.display = '');
                return;
            }

            // Find which groups contain at least one matching facility
            const matchingGroups = new Set();
            allItems.forEach(item => {
                const name = item.getAttribute('data-facility-name');
                if (activeFilters.has(name)) {
                    item.classList.add('highlighted');
                    const col = item.closest('.facility-group-col');
                    if (col) matchingGroups.add(col);
                }
            });

            // Dim non-matching groups
            allCols.forEach(col => {
                if (!matchingGroups.has(col)) {
                    col.classList.add('dimmed');
                }
            });

            // Filter room cards: show only rooms whose benefits match ALL active amenity filters
            const facilityKeywords = {
                'Free Wi-Fi in all rooms!': ['wifi', 'wi-fi'],
                'Wi-Fi in public areas': ['wifi', 'wi-fi'],
                'Internet': ['internet', 'wifi', 'wi-fi'],
                'Swimming pool': ['pool', 'swimming'],
                'Swimming pool [outdoor]': ['pool', 'swimming'],
                'Fitness center': ['fitness', 'gym'],
                'Gym/fitness': ['fitness', 'gym'],
                'Bar': ['bar'],
                'Restaurants': ['restaurant'],
                'Elevator': ['elevator', 'lift'],
                'Laundry service': ['laundry'],
                'Air conditioning': ['air conditioning', 'aircon', 'a/c'],
                'Parking': ['parking', 'car park'],
                'Car park [on-site]': ['parking', 'car park'],
                'Security [24-hour]': ['security'],
                'Front desk [24-hour]': ['front desk', 'reception'],
                'Breakfast [buffet]': ['breakfast'],
                'Breakfast [continental]': ['breakfast'],
                'Concierge': ['concierge'],
                'Luggage storage': ['luggage'],
                'Wheelchair accessible': ['wheelchair', 'accessible'],
                'Family room': ['family'],
                'Smoke-free property': ['smoke-free', 'non-smoking'],
                'Taxi service': ['taxi'],
                'Currency exchange': ['currency'],
                'Computer station': ['computer'],
                'Poolside bar': ['pool', 'bar'],
                'Vending machine': ['vending'],
                'Contactless check-in/out': ['contactless', 'check-in'],
                'CCTV in common areas': ['cctv'],
                'Shower': ['shower'],
                'Hair dryer': ['hair dryer', 'hairdryer'],
                'Coffee/tea maker': ['coffee', 'tea'],
                'Telephone': ['telephone', 'phone'],
                'Desk': ['desk'],
                'In-room safe box': ['safe'],
                'Private bathroom': ['bathroom', 'bath'],
                'Satellite/cable channels': ['satellite', 'cable', 'tv'],
                'Non-smoking rooms': ['non-smoking', 'smoke-free'],
            };

            roomCards.forEach(card => {
                const benefits = JSON.parse(card.getAttribute('data-room-benefits') || '[]');
                const hasAll = [...activeFilters].every(facilityName => {
                    const keywords = facilityKeywords[facilityName] || [facilityName.toLowerCase()];
                    return keywords.some(kw => benefits.some(b => b.includes(kw)));
                });
                card.style.display = hasAll ? '' : 'none';
            });
        }

        function clearAllAmenityFilters() {
            activeFilters.clear();
            document.querySelectorAll('.amenity-chip.active').forEach(el => el.classList.remove('active'));
            applyAllFilters();
        }

        // ========================
        // Room Filter Pill Logic
        // ========================
        let activeRoomFilters = new Set();

        function toggleRoomFilter(el) {
            const filter = el.getAttribute('data-filter');
            el.classList.toggle('active');

            if (activeRoomFilters.has(filter)) {
                activeRoomFilters.delete(filter);
            } else {
                activeRoomFilters.add(filter);
            }

            applyAllFilters();
        }

        function clearAllFilters() {
            activeFilters.clear();
            activeRoomFilters.clear();
            document.querySelectorAll('.amenity-chip.active').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.room-filter-pill.active').forEach(el => el.classList.remove('active'));
            applyAllFilters();
        }

        function applyAllFilters() {
            // First apply amenity chip filters (facility section highlighting)
            applyFacilityFilter();

            // Then apply room filter pills on top
            const roomCards = document.querySelectorAll('.room-type-card');
            const noRoomsMsg = document.getElementById('noRoomsMessage');

            if (activeRoomFilters.size === 0 && activeFilters.size === 0) {
                // No filters — show all rates
                document.querySelectorAll('.rate-option-row').forEach(row => row.style.display = '');
                roomCards.forEach(card => card.style.display = '');
                if (noRoomsMsg) noRoomsMsg.classList.add('d-none');
                return;
            }

            // Filter individual rate rows by room filter pills
            if (activeRoomFilters.size > 0) {
                document.querySelectorAll('.rate-option-row').forEach(row => {
                    let visible = true;
                    const roomName = row.getAttribute('data-room-name') || '';

                    if (activeRoomFilters.has('breakfast') && row.getAttribute('data-has-breakfast') !== '1') {
                        visible = false;
                    }
                    if (activeRoomFilters.has('cancellation') && row.getAttribute('data-has-cancellation') !== '1') {
                        visible = false;
                    }
                    if (activeRoomFilters.has('non-smoking') && !roomName.includes('non-smoking') && !roomName.includes('nonsmoking')) {
                        visible = false;
                    }
                    if (activeRoomFilters.has('twin') && !roomName.includes('twin')) {
                        visible = false;
                    }
                    if (activeRoomFilters.has('premium') && !roomName.includes('premium')) {
                        visible = false;
                    }

                    row.style.display = visible ? '' : 'none';
                });
            } else {
                document.querySelectorAll('.rate-option-row').forEach(row => row.style.display = '');
            }

            // Hide room cards that have no visible rate rows (or were hidden by amenity filter)
            let visibleCardCount = 0;
            roomCards.forEach(card => {
                if (card.style.display === 'none') {
                    // Already hidden by amenity filter
                    return;
                }
                const visibleRates = card.querySelectorAll('.rate-option-row:not([style*="display: none"])');
                if (visibleRates.length === 0 && activeRoomFilters.size > 0) {
                    card.style.display = 'none';
                } else {
                    visibleCardCount++;
                }
            });

            if (noRoomsMsg) {
                noRoomsMsg.classList.toggle('d-none', visibleCardCount > 0);
            }
        }

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

                // --- Price breakdown rows ---
                const rateExclusive = parseFloat(data.rateExclusive || 0);
                const rateTax       = parseFloat(data.rateTax || 0);
                const rateFees      = parseFloat(data.rateFees || 0);

                const rateRateRow = document.getElementById('modalRoomRateRow');
                if (rateExclusive > 0) {
                    document.getElementById('modalRoomRate').textContent = 'US$' + rateExclusive.toFixed(2);
                    rateRateRow.style.removeProperty('display');
                } else {
                    rateRateRow.style.setProperty('display', 'none', 'important');
                }

                const taxRow = document.getElementById('modalTaxesRow');
                if (rateTax > 0) {
                    document.getElementById('modalTaxes').textContent = 'US$' + rateTax.toFixed(2);
                    taxRow.style.removeProperty('display');
                } else {
                    taxRow.style.setProperty('display', 'none', 'important');
                }

                const feesRow = document.getElementById('modalFeesRow');
                if (rateFees > 0) {
                    document.getElementById('modalFees').textContent = 'US$' + rateFees.toFixed(2);
                    feesRow.style.removeProperty('display');
                } else {
                    feesRow.style.setProperty('display', 'none', 'important');
                }

                // --- Included / Excluded surcharges ---
                const surcharges = JSON.parse(data.surcharges || '[]');
                const includedSurcharges = surcharges.filter(s => s.type === 'Included');
                const excludedSurcharges = surcharges.filter(s => s.type === 'Excluded' || s.type === 'Mandatory');

                const inclContainer = document.getElementById('modalIncludedSurchargesContainer');
                inclContainer.innerHTML = '';
                includedSurcharges.forEach(function(s) {
                    inclContainer.innerHTML +=
                        '<div class="d-flex justify-content-between mb-2">' +
                            '<span class="text-muted small">' + s.name + '</span>' +
                            '<span class="small fw-medium">US$' + parseFloat(s.amount).toFixed(2) + '</span>' +
                        '</div>';
                });

                const excSection = document.getElementById('modalPayAtHotelChargesSection');
                const excList    = document.getElementById('modalPayAtHotelChargesList');
                if (excludedSurcharges.length > 0) {
                    excList.innerHTML = '';
                    excludedSurcharges.forEach(function(s) {
                        const amtLabel = parseFloat(s.amount) > 0 ? 'US$' + parseFloat(s.amount).toFixed(2) : 'Varies';
                        excList.innerHTML +=
                            '<div class="d-flex justify-content-between mb-1">' +
                                '<span class="small" style="color:#92400e;">' + s.name + '</span>' +
                                '<span class="small fw-medium" style="color:#92400e;">' + amtLabel + '</span>' +
                            '</div>';
                    });
                    excSection.style.display = '';
                } else {
                    excSection.style.display = 'none';
                }
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
                document.getElementById('formBlockId').value = data.blockId;
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
                document.getElementById('formRateExclusive').value = data.rateExclusive;
                document.getElementById('formRateTax').value = data.rateTax;
                document.getElementById('formRateFees').value = data.rateFees;
                document.getElementById('formSurchargeAmount').value = data.surchargeAmount || 0;
                document.getElementById('formRateCurrency').value = data.rateCurrency;
                document.getElementById('formRateMethod').value = data.rateMethod;
                document.getElementById('formPaymentModel').value = data.paymentModel;
                document.getElementById('formBenefits').value = data.benefits || '[]';
                document.getElementById('formSurcharges').value = data.surcharges || '[]';
                document.getElementById('formSurchargesRaw').value = data.surchargesRaw || '[]';
                document.getElementById('formCancellationPolicy').value = data.cancellationPolicy || '';
                document.getElementById('formHotelRemarks').value = data.hotelRemarks || '';
                document.getElementById('formHotelAddress').value = data.hotelAddress || '';

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
                        {{-- ── Paid Online ── --}}
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge rounded-pill" style="background:#e0f2fe; color:#0369a1; font-size:0.65rem; font-weight:600;">PAID ONLINE</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Price per night</span>
                            <span class="small fw-medium" id="modalPricePerNight">US$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Duration</span>
                            <span class="small fw-medium" id="modalNightsSummary"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="modalRoomRateRow" style="display:none !important;">
                            <span class="text-muted small">Room rate</span>
                            <span class="small fw-medium" id="modalRoomRate">US$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="modalTaxesRow" style="display:none !important;">
                            <span class="text-muted small">Taxes</span>
                            <span class="small fw-medium" id="modalTaxes">US$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="modalFeesRow" style="display:none !important;">
                            <span class="text-muted small">Fees</span>
                            <span class="small fw-medium" id="modalFees">US$0.00</span>
                        </div>
                        <div id="modalIncludedSurchargesContainer"></div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold">Total (paid online)</span>
                            <span class="fw-bold" id="modalTotalPrice" style="font-size: 1.2rem; color: var(--primary-navy);">US$0.00</span>
                        </div>
                        <small class="text-muted d-block">Includes all taxes &amp; fees above</small>

                        {{-- ── Pay at Hotel ── --}}
                        <div id="modalPayAtHotelChargesSection" class="mt-3 p-3 rounded-3" style="background:#fff8e1; border:1px solid #fde68a; border-top:2px solid #f59e0b; display:none;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-building" style="color:#d97706;"></i>
                                    <span class="fw-bold small" style="color:#92400e;">PAY AT HOTEL</span>
                                </div>
                                <span class="badge rounded-pill" style="background:#fef3c7; color:#92400e; font-size:0.6rem;">Not included in total</span>
                            </div>
                            <div id="modalPayAtHotelChargesList"></div>
                            <small class="d-block mt-2" style="font-size:0.68rem; color:#b45309;">Collected directly by the hotel at check-in or check-out.</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer booking-modal-footer">
                    <form action="{{ route('booking.store') }}" method="POST" class="w-100">
                        @csrf
                        <input type="hidden" name="searched_id" id="formSearchedId" value="{{ $searchedId ?? '' }}">
                        <input type="hidden" name="property_id" id="formPropertyId">
                        <input type="hidden" name="property_name" id="formPropertyName">
                        <input type="hidden" name="property_image" id="formPropertyImage">
                        <input type="hidden" name="room_id" id="formRoomId">
                        <input type="hidden" name="block_id" id="formBlockId">
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
                        <input type="hidden" name="rate_exclusive" id="formRateExclusive">
                        <input type="hidden" name="rate_tax" id="formRateTax">
                        <input type="hidden" name="rate_fees" id="formRateFees">
                        <input type="hidden" name="surcharge_amount" id="formSurchargeAmount" value="0">
                        <input type="hidden" name="rate_currency" id="formRateCurrency">
                        <input type="hidden" name="rate_method" id="formRateMethod">
                        <input type="hidden" name="payment_model" id="formPaymentModel">
                        <input type="hidden" name="payment_type" id="formPaymentType" value="pay_now">
                        <input type="hidden" name="benefits" id="formBenefits">
                        <input type="hidden" name="surcharges" id="formSurcharges">
                        <input type="hidden" name="surcharges_raw" id="formSurchargesRaw">
                        <input type="hidden" name="cancellation_policy_text" id="formCancellationPolicy">
                        <input type="hidden" name="hotel_remarks" id="formHotelRemarks">
                        <input type="hidden" name="hotel_address" id="formHotelAddress">

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