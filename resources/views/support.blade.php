@extends('layouts.index')
@section('content')
    @if(Auth::check())
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
        @include('partials.dashboard-nav')
    @else
        @include('partials.login-nav')
    @endif

    <div class="container py-5" style="max-width: 800px;">
        <!-- Header -->
        <h3 class="fw-bold mb-4" style="color: var(--primary-navy, #1a1a2e);">Help Center</h3>
        <p class="mb-4">Hi, <strong>{{ Auth::check() ? Auth::user()->first_name : 'Traveler' }}</strong></p>

        <!-- Search -->
        <div class="d-flex gap-2 mb-5">
            <div class="position-relative flex-grow-1">
                <i class="bi bi-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af;"></i>
                <input type="text" class="form-control border" placeholder="How can we help?" style="padding-left: 2.5rem; border-radius: 0.5rem; height: 46px;" id="supportSearch">
            </div>
            <button class="btn text-white fw-medium px-4" style="background: var(--primary-navy, #1a1a2e); border-radius: 0.5rem;" onclick="filterArticles()">Search</button>
        </div>

        <!-- Help Articles Grid -->
        <h5 class="fw-bold mb-3">Explore help articles</h5>

        <div class="row g-3" id="helpArticlesGrid">
            @php
                $articles = [
                    ['icon' => 'bi-airplane', 'label' => 'Flights'],
                    ['icon' => 'bi-arrow-repeat', 'label' => 'Refunds & Charges'],
                    ['icon' => 'bi-car-front', 'label' => 'Car Rentals'],
                    ['icon' => 'bi-building', 'label' => 'Stays'],
                    ['icon' => 'bi-ticket-perforated', 'label' => 'Packages'],
                    ['icon' => 'bi-signpost-split', 'label' => 'Activities'],
                    ['icon' => 'bi-map', 'label' => 'Things to do'],
                    ['icon' => 'bi-person-circle', 'label' => 'Account'],
                    ['icon' => 'bi-shield-lock', 'label' => 'Privacy'],
                    ['icon' => 'bi-lock', 'label' => 'Security'],
                    ['icon' => 'bi-star', 'label' => 'Loyalty & Rewards'],
                    ['icon' => 'bi-exclamation-triangle', 'label' => 'Travel Alerts'],
                ];
            @endphp

            @foreach($articles as $article)
            <div class="col-md-4 help-article-item">
                <a href="#" class="d-flex align-items-center justify-content-between text-decoration-none text-dark p-3 border rounded-3 h-100 help-article-link">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi {{ $article['icon'] }}" style="font-size: 1.1rem; color: var(--primary-navy, #1a1a2e);"></i>
                        <span class="fw-medium">{{ $article['label'] }}</span>
                    </div>
                    <i class="bi bi-chevron-right text-muted small"></i>
                </a>
            </div>
            @endforeach
        </div>

        <p class="text-muted small mt-4 text-center" id="noResults" style="display: none;">No matching articles found.</p>
    </div>

    <style>
        .help-article-link {
            transition: all 0.2s ease;
            border-color: #e5e7eb !important;
        }
        .help-article-link:hover {
            background: #f9fafb;
            border-color: #c7d2fe !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
    </style>

    @push('scripts')
    <script>
        function filterArticles() {
            const query = document.getElementById('supportSearch').value.toLowerCase().trim();
            const items = document.querySelectorAll('.help-article-item');
            let visible = 0;
            items.forEach(item => {
                const label = item.textContent.toLowerCase();
                const match = !query || label.includes(query);
                item.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            document.getElementById('noResults').style.display = visible === 0 ? '' : 'none';
        }
        document.getElementById('supportSearch').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') filterArticles();
        });
    </script>
    @endpush
@endsection
