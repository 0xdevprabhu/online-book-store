@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="home-container">
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <span class="hero-badge">Read and Inspire</span>
            <h1>Online Book Store</h1>
            <p>Search and read your favorite books. Expand your knowledge today.</p>
            <div class="hero-actions">
                <a href="{{ url('/books') }}" class="btn-primary">Browse Books <i class="fa-solid fa-arrow-right"></i></a>
                <a href="{{ url('/books') }}?search=general" class="btn-secondary">Explore Catalog</a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="visual-card-bg"></div>
            <div class="visual-card">
                <h3>Featured Selection</h3>
                <div class="visual-book">
                    <div class="book-cover"></div>
                    <div class="book-details">
                        <h4>Research & Learning</h4>
                        <p>Explore high-quality scientific and educational books.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-book-open"></i></div>
            <h3>Wide Catalog</h3>
            <p>Thousands of novels, scientific, and educational books all in one place.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-bolt"></i></div>
            <h3>Instant Access</h3>
            <p>Search for books easily and get pricing and stock details instantly.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-earth-americas"></i></div>
            <h3>Live Analytics</h3>
            <p>Real-time weather data and book details delivered instantly via public APIs.</p>
        </div>
    </section>

    <!-- Live Updates Section -->
    <section class="api-data-section">
        <div class="section-header">
            <h2>Live Updates</h2>
            <span class="live-indicator"><span class="pulse"></span> Active API Data</span>
        </div>
        <div class="api-card">
            @if(isset($weatherData))
                <div class="weather-widget">
                    <div class="weather-main">
                        <span class="weather-icon"><i class="fa-solid fa-cloud-sun"></i></span>
                        <div>
                            <h3>{{ $weatherData['name'] ?? 'Chennai' }} Weather</h3>
                            <p class="weather-temp">{{ isset($weatherData['main']['temp']) ? round($weatherData['main']['temp']) : 'N/A' }}°C</p>
                        </div>
                    </div>
                    <div class="weather-details">
                        <div class="detail-item">
                            <span class="label">Condition</span>
                            <span class="value">{{ ucfirst($weatherData['weather'][0]['description'] ?? 'clear sky') }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Humidity</span>
                            <span class="value">{{ $weatherData['main']['humidity'] ?? 'N/A' }}%</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Wind Speed</span>
                            <span class="value">{{ $weatherData['wind']['speed'] ?? 'N/A' }} m/s</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="recommendation-widget">
                    <span class="widget-badge">API Recommendation</span>
                    <h3>Featured Recommendation</h3>
                    <p>Click the "Browse Books" button to see our hand-picked recommendation list.</p>
                </div>
            @endif
        </div>
    </section>

</div>
@endsection

@push('scripts')
    <script>
        console.log("Premium Home page loaded successfully.");
    </script>
@endpush