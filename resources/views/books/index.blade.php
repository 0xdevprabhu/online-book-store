@extends('layouts.app')

@push('styles')
    <!-- CSS file for this book listing page -->
    <link rel="stylesheet" href="{{ asset('css/book-list.css') }}">
@endpush

@section('content')
<div class="books-page-container">
    
    <!-- Search Bar Section -->
    <section class="search-section">
        <form action="{{ url('/books') }}" method="GET" class="search-form">
            <input 
                type="text" 
                name="search" 
                placeholder="Search for book title or author name..." 
                value="{{ request('search') }}"
                class="search-input"
            >
            <select name="category" class="category-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
        </form>
    </section>

    <!-- Books Grid -->
    <section class="books-section">
        <h2>Our Book Collection</h2>
        
        @if($books->count() > 0)
            <div class="books-grid">
                @foreach($books as $book)
                    <div class="book-card">
                        <div class="book-info">
                            <h3 class="book-title">{{ $book->title }}</h3>
                            <p class="book-author">By {{ $book->author }}</p>
                            @if($book->category)
                                <p class="book-category" style="font-size: 0.85rem; color: #3b82f6; margin-bottom: 0.5rem; font-weight: 500;">
                                    <i class="fa-solid fa-tag"></i> {{ $book->category->name }}
                                </p>
                            @endif
                            <p class="book-price">₹{{ number_format($book->price, 2) }}</p>
                            
                            <!-- Check if the book is in stock -->
                            @if($book->is_available)
                                <span class="badge available"><i class="fa-solid fa-circle-check"></i> In Stock</span>
                            @else
                                <span class="badge out-of-stock"><i class="fa-solid fa-circle-xmark"></i> Unavailable</span>
                            @endif
                        </div>
                        <div class="book-action">
                            <a href="{{ url('/books/' . $book->id) }}" class="btn-view">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-books">
                <p>Sorry, no books were found matching your search.</p>
            </div>
        @endif
    </section>

</div>
@endsection