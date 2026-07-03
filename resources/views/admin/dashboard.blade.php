@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dash.css') }}">
@endpush

@section('content')
<div class="admin-layout">
    
    <!-- Left Sidebar Section -->
    <aside class="admin-sidebar">
        <div class="sidebar-profile">
            <div class="profile-avatar-wrapper">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="profile-info">
                <h3>Admin Panel</h3>
                <span>Authorized Session</span>
            </div>
        </div>
        
        <nav class="sidebar-menu">
            <button type="button" class="sidebar-menu-item active" data-target="dashboard-panel">
                <span class="menu-icon"><i class="fa-solid fa-chart-simple"></i></span>
                Dashboard
            </button>
            <button type="button" class="sidebar-menu-item" data-target="inventory-panel">
                <span class="menu-icon"><i class="fa-solid fa-book"></i></span>
                Books List
            </button>
        </nav>

        <div class="sidebar-logout">
            <form action="{{ url('/admin/logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-sidebar-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Right Content Section -->
    <main class="admin-main">
        
        <!-- Top Sub-Navbar hugging the Sidebar Corner -->
        <div class="admin-top-navbar">
            <h2 class="admin-top-title">Online Book Store Admin</h2>
            <div class="admin-top-tabs">
                <button type="button" class="admin-tab-btn active" data-target="dashboard-panel">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </button>
                <button type="button" class="admin-tab-btn" data-target="inventory-panel">
                    <i class="fa-solid fa-book"></i> Books List
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="success-alert">
                <span class="alert-icon"><i class="fa-solid fa-circle-check"></i></span>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="error-alert">
                <span class="alert-icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
                <p>An error occurred while saving the book. Please check the details in the form.</p>
            </div>
        @endif

        <!-- Panel 1: Dashboard Panel (Stats + Recently Added) -->
        <section id="dashboard-panel" class="dash-panel active">
            
            <!-- Statistics Row (4 Cards in One Row) -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon books"><i class="fa-solid fa-book"></i></div>
                    <div class="stat-data">
                        <h3>Total Books</h3>
                        <p class="stat-number">{{ $books->count() }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon available"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="stat-data">
                        <h3>In Stock</h3>
                        <p class="stat-number">{{ $books->where('is_available', 1)->count() }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon out-of-stock"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div class="stat-data">
                        <h3>Out of Stock</h3>
                        <p class="stat-number">{{ $books->where('is_available', 0)->count() }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon value"><i class="fa-solid fa-wallet"></i></div>
                    <div class="stat-data">
                        <h3>Total Value</h3>
                        <p class="stat-number">₹{{ number_format($books->sum('price'), 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Recently Added Section -->
            <div class="inventory-section">
                <div class="panel-header">
                    <h2>Recently Added Books</h2>
                    <p>Showing the last 5 books added to the store catalog.</p>
                </div>

                <div class="table-card">
                    <div class="table-responsive">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $recentBooks = $books->sortByDesc('created_at')->take(5);
                                @endphp
                                @if($recentBooks->count() > 0)
                                    @foreach($recentBooks as $book)
                                        <tr>
                                            <td><strong class="book-title-cell">{{ $book->title }}</strong></td>
                                            <td>{{ $book->author }}</td>
                                            <td class="price-cell">₹{{ number_format($book->price, 2) }}</td>
                                            <td>
                                                @if($book->is_available)
                                                    <span class="status-badge available"><i class="fa-solid fa-circle-check"></i> Available</span>
                                                @else
                                                    <span class="status-badge unavailable"><i class="fa-solid fa-circle-xmark"></i> Out of Stock</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No books available in inventory.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>

        <!-- Panel 2: Books List Panel (Full inventory, Search bar, Add product) -->
        <section id="inventory-panel" class="dash-panel">
            <div class="inventory-section">
                <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap;">
                    <div>
                        <h2>Books Inventory</h2>
                        <p>Manage, edit, or delete items from the bookstore.</p>
                    </div>
                    <button type="button" class="btn-submit" id="btn-trigger-modal">
                        <i class="fa-solid fa-plus"></i> Add Product
                    </button>
                </div>

                <!-- Client-Side Search Bar -->
                <div class="table-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="table-search" class="table-search-input" placeholder="Search books by title or author...">
                </div>

                <div class="table-card">
                    <div class="table-responsive">
                        <table class="dash-table" id="inventory-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($books->count() > 0)
                                    @foreach($books as $book)
                                        <tr class="book-row">
                                            <td><strong class="book-title-cell search-title">{{ $book->title }}</strong></td>
                                            <td class="search-author">{{ $book->author }}</td>
                                            <td class="price-cell">₹{{ number_format($book->price, 2) }}</td>
                                            <td>
                                                @if($book->is_available)
                                                    <span class="status-badge available"><i class="fa-solid fa-circle-check"></i> Available</span>
                                                @else
                                                    <span class="status-badge unavailable"><i class="fa-solid fa-circle-xmark"></i> Out of Stock</span>
                                                @endif
                                            </td>
                                            <td class="action-buttons">
                                                <button type="button" class="btn-edit-action" 
                                                        data-id="{{ $book->id }}"
                                                        data-title="{{ $book->title }}"
                                                        data-author="{{ $book->author }}"
                                                        data-price="{{ $book->price }}"
                                                        data-available="{{ $book->is_available }}"
                                                        data-description="{{ $book->description }}">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                </button>
                                                
                                                <form action="{{ url('/admin/books/' . $book->id) }}" method="POST" class="delete-book-form" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-delete-action btn-trigger-delete" data-title="{{ $book->title }}">
                                                        <i class="fa-solid fa-trash-can"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No books available. Please add a book.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </main>
</div>

<!-- Add Book Modal Overlay -->
<div class="modal-overlay" id="add-book-modal">
    <div class="modal-container animate-slide">
        <div class="modal-header">
            <h3 id="modal-title-text">Add New Book</h3>
            <button type="button" class="btn-close-modal" id="btn-close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/admin/books') }}" method="POST" class="crud-form" id="crud-book-form">
                @csrf
                <div id="method-field-container"></div>

                <div class="form-group autocomplete-container">
                    <label for="title">Book Title *</label>
                    <input type="text" id="title" name="title" autocomplete="off" required value="{{ old('title') }}">
                    <div id="suggestions-list" class="suggestions-dropdown"></div>
                    @error('title')
                        <span class="validation-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" id="author" name="author" required value="{{ old('author') }}">
                    @error('author')
                        <span class="validation-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price (INR) *</label>
                        <input type="number" id="price" name="price" step="0.01" required value="{{ old('price') }}">
                        @error('price')
                            <span class="validation-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="is_available">Availability *</label>
                        <select id="is_available" name="is_available" required>
                            <option value="1" {{ old('is_available') == '1' ? 'selected' : '' }}>In Stock</option>
                            <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                        @error('is_available')
                            <span class="validation-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="validation-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" id="btn-cancel-modal">Cancel</button>
                    <button type="submit" class="btn-submit" id="btn-save-modal-text"><i class="fa-solid fa-plus"></i> Save Book</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal Overlay -->
<div class="modal-overlay" id="delete-confirm-modal">
    <div class="modal-container animate-slide" style="max-width: 450px;">
        <div class="modal-header danger">
            <h3>Confirm Deletion</h3>
            <button type="button" class="btn-close-modal" id="btn-close-delete-modal">&times;</button>
        </div>
        <div class="modal-body">
            <p class="delete-warning-text">
                Are you sure you want to delete book <strong id="delete-book-title-display"></strong>? This action cannot be undone.
            </p>
            <div class="modal-footer" style="margin-top: 2rem;">
                <button type="button" class="btn-cancel" id="btn-cancel-delete-modal">Cancel</button>
                <button type="button" class="btn-confirm-delete" id="btn-confirm-delete-action">Delete</button>
            </div>
        </div>
    </div>
</div>

@if($errors->any() && old('_token'))
    <!-- If validation redirects back with errors, automatically reopen the modal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('add-book-modal');
            if (modal) {
                modal.classList.add('active');
            }
        });
    </script>
@endif
@endsection

@push('scripts')
    <script>
        // Set Google Books API Key
        window.googleBooksApiKey = "{{ config('services.google.books_key') }}";

        // Cache existing book details as local catalog suggestions for rate limit / offline fallback
        window.localBooksCatalog = @json($books->map(function($book) {
            return [
                'title' => $book->title,
                'author' => $book->author,
                'description' => $book->description ?? ''
            ];
        }));
    </script>
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush