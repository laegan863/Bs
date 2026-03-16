@extends('layouts.app')
@section('content')
<section class="py-4">
    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $cityName }}</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1">Hotels in {{ $cityName }}</h2>
                <p class="text-muted mb-0">{{ count($hotels) }} {{ Str::plural('property', count($hotels)) }} found</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <label class="small text-muted fw-medium me-1">Sort by:</label>
                <select class="form-select form-select-sm" id="hotelSort" style="width: auto;">
                    <option value="rating">Best Rating</option>
                    <option value="reviews">Most Reviews</option>
                    <option value="stars-desc">Stars (High to Low)</option>
                    <option value="stars-asc">Stars (Low to High)</option>
                    <option value="name">Name (A-Z)</option>
                </select>
            </div>
        </div>

        @if(count($hotels) === 0)
            <div class="text-center py-5">
                <i class="bi bi-building-slash" style="font-size: 3rem; color: #cbd5e1;"></i>
                <h5 class="mt-3 text-muted">No hotels found in {{ $cityName }}</h5>
                <p class="text-muted">Try searching for a different city.</p>
                <a href="{{ route('landing') }}" class="btn btn-outline-primary mt-2">Back to Home</a>
            </div>
        @else
            <div class="row" id="hotelList">
                @foreach($hotels as $hotel)
                <div class="col-12 mb-3 hotel-list-item"
                     data-rating="{{ $hotel['rating_average'] ?? 0 }}"
                     data-reviews="{{ $hotel['number_of_reviews'] ?? 0 }}"
                     data-stars="{{ $hotel['star_rating'] ?? 0 }}"
                     data-name="{{ $hotel['hotel_name'] ?? '' }}">
                    <a href="{{ route('search', ['property' => $hotel['hotel_id'], 'checkin' => now()->format('Y-m-d'), 'checkout' => now()->addDay()->format('Y-m-d'), 'adults' => 2, 'children' => 0, 'rooms' => 1]) }}" class="text-decoration-none text-dark">
                        <div class="hotel-listing-card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="hotel-listing-img">
                                        <img src="{{ asset('assets/images/login-1.jpg') }}" alt="{{ $hotel['hotel_name'] ?? 'Hotel' }}">
                                        <span class="hotel-listing-type">{{ $hotel['accommodation_type'] ?? 'Hotel' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="hotel-listing-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="fw-bold mb-1">{{ $hotel['hotel_name'] ?? 'Unknown Hotel' }}</h5>
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    @php $stars = floatval($hotel['star_rating'] ?? 0); @endphp
                                                    <div class="hotel-listing-stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $stars)
                                                                <i class="bi bi-star-fill text-warning"></i>
                                                            @elseif($i - 0.5 <= $stars)
                                                                <i class="bi bi-star-half text-warning"></i>
                                                            @else
                                                                <i class="bi bi-star text-warning"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span class="small text-muted">{{ $hotel['star_rating'] ?? 'N/A' }} stars</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                @php
                                                    $rating = floatval($hotel['rating_average'] ?? 0);
                                                    $ratingLabel = $rating >= 9 ? 'Exceptional' : ($rating >= 8 ? 'Excellent' : ($rating >= 7 ? 'Very Good' : ($rating >= 6 ? 'Good' : 'Rating')));
                                                    $ratingColor = $rating >= 8 ? '#1a237e' : ($rating >= 6 ? '#2e7d32' : '#f57c00');
                                                @endphp
                                                <span class="hotel-listing-rating" style="background: {{ $ratingColor }};">{{ $hotel['rating_average'] ?? 'N/A' }}</span>
                                                <div class="small text-muted mt-1">{{ $ratingLabel }}</div>
                                                <div class="small text-muted">{{ number_format($hotel['number_of_reviews'] ?? 0) }} reviews</div>
                                            </div>
                                        </div>

                                        @if(!empty($hotel['owner_name']))
                                        <div class="small text-muted mb-2">
                                            <i class="bi bi-building me-1"></i> {{ $hotel['owner_name'] }}
                                        </div>
                                        @endif

                                        @if(!empty($hotel['remark']) && !is_array($hotel['remark']))
                                        <p class="small text-muted mb-2 hotel-listing-remark">{{ Str::limit($hotel['remark'], 120) }}</p>
                                        @endif

                                        <div class="d-flex align-items-center gap-3 mt-auto">
                                            @if(isset($hotel['child_and_extra_bed_policy']['children_stay_free']) && $hotel['child_and_extra_bed_policy']['children_stay_free'] === 'true')
                                            <span class="badge bg-success-subtle text-success small"><i class="bi bi-check-circle me-1"></i>Kids stay free</span>
                                            @endif
                                            <span class="badge bg-primary-subtle text-primary small"><i class="bi bi-geo-alt me-1"></i>View on map</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<script>
document.getElementById('hotelSort')?.addEventListener('change', function() {
    const list = document.getElementById('hotelList');
    const items = Array.from(list.querySelectorAll('.hotel-list-item'));
    const sortBy = this.value;

    items.sort(function(a, b) {
        switch(sortBy) {
            case 'rating': return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
            case 'reviews': return parseInt(b.dataset.reviews) - parseInt(a.dataset.reviews);
            case 'stars-desc': return parseFloat(b.dataset.stars) - parseFloat(a.dataset.stars);
            case 'stars-asc': return parseFloat(a.dataset.stars) - parseFloat(b.dataset.stars);
            case 'name': return a.dataset.name.localeCompare(b.dataset.name);
            default: return 0;
        }
    });

    items.forEach(function(item) { list.appendChild(item); });
});
</script>
@endsection
