@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dash.css') }}">
@endpush

@section('content')
<div class="form-container">
    
    <div class="form-header">
        <h2>Add New Book </h2>
        <a href="{{ url('/admin/dashboard') }}" class="btn-back">&larr; Back to Dashboard</a>
    </div>

    <form action="{{ url('/admin/books') }}" method="POST" class="crud-form">
        @csrf

        <div class="form-group">
            <label for="title">Book Title *</label>
            <input type="text" id="title" name="title" required value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="author">Author *</label>
            <input type="text" id="author" name="author" required value="{{ old('author') }}">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price">Price (INR) * </label>
                <input type="number" id="price" name="price" step="0.01" required value="{{ old('price') }}">
            </div>

            <div class="form-group">
                <label for="is_available">Availability * </label>
                <select id="is_available" name="is_available" required>
                    <option value="1" {{ old('is_available') == '1' ? 'selected' : '' }}>In Stock </option>
                    <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Out of Stock </option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn-submit">Save Book</button>
    </form>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush