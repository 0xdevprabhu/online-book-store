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
            <span class="live-indicator"><span class="pulse"></span> Recently Added</span>
        </div>
        <div class="recent-books-grid">
            @if(isset($recentBooks) && $recentBooks->count() > 0)
                @foreach($recentBooks as $book)
                    <div class="recent-book-card">
                        <div class="recent-book-cover">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <h3 class="recent-book-title" title="{{ $book->title }}">{{ $book->title }}</h3>
                        <span class="recent-book-author">by {{ $book->author }}</span>
                        <div class="recent-book-price">₹{{ number_format($book->price, 2) }}</div>
                        <a href="{{ url('/books/' . $book->id) }}" class="btn-view-details">
                            View Details <i class="fa-solid fa-circle-info"></i>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="api-card" style="grid-column: span 4; text-align: center; color: var(--text-secondary);">
                    <p>No books recently added to the store catalogue.</p>
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