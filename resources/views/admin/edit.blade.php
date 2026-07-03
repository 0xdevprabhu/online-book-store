@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dash.css') }}">
@endpush

@section('content')
<div class="form-container">
    
    <div class="form-header">
        <h2>Edit Book: {{ $book->title }}</h2>
        <a href="{{ url('/admin/dashboard') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
    </div>

    <form action="{{ url('/admin/books/' . $book->id) }}" method="POST" class="crud-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Book Title *</label>
            <input type="text" id="title" name="title" required value="{{ old('title', $book->title) }}">
            @error('title')
                <span class="validation-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="author">Author *</label>
            <input type="text" id="author" name="author" required value="{{ old('author', $book->author) }}">
            @error('author')
                <span class="validation-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price">Price (INR) *</label>
                <input type="number" id="price" name="price" step="0.01" required value="{{ old('price', $book->price) }}">
                @error('price')
                    <span class="validation-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_available">Availability *</label>
                <select id="is_available" name="is_available" required>
                    <option value="1" {{ old('is_available', $book->is_available) == 1 ? 'selected' : '' }}>In Stock</option>
                    <option value="0" {{ old('is_available', $book->is_available) == 0 ? 'selected' : '' }}>Out of Stock</option>
                </select>
                @error('is_available')
                    <span class="validation-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description (Optional)</label>
            <textarea id="description" name="description" rows="5">{{ old('description', $book->description) }}</textarea>
            @error('description')
                <span class="validation-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Update Book</button>
    </form>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush