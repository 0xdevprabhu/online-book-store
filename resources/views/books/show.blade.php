@extends('layouts.app')

@push('styles')
    <!-- CSS file for this book details page -->
    <link rel="stylesheet" href="{{ asset('css/book-detail.css') }}">
@endpush

@section('content')
<div class="book-detail-container">
    
    <!-- Back Button -->
    <div class="back-nav">
        <a href="{{ url('/books') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Back to Books</a>
    </div>

    <!-- Book Details Card -->
    <div class="detail-card">
        <div class="detail-header">
            <h1 class="detail-title">{{ $book->title }}</h1>
            <p class="detail-author">Author: <strong>{{ $book->author }}</strong></p>
        </div>

        <div class="detail-body">
            <div class="info-group">
                <span class="info-label">Category:</span>
                <span class="info-value">{{ $book->category->name ?? 'General' }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Price:</span>
                <span class="info-value price-tag">₹{{ number_format($book->price, 2) }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Availability:</span>
                @if($book->is_available)
                    <span class="badge-large available"><i class="fa-solid fa-circle-check"></i> In Stock</span>
                @else
                    <span class="badge-large out-of-stock"><i class="fa-solid fa-circle-xmark"></i> Currently Out of Stock</span>
                @endif
            </div>

            @if($book->description)
                <div class="detail-description">
                    <h3>Book Description:</h3>
                    <p>{{ $book->description }}</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection