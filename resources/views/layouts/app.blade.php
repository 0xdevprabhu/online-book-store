<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Book Store</title>
    
    <!-- Google Fonts for Premium Typography -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    @stack('styles')
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            @if(request()->is('admin*'))
                <a href="{{ url('/admin/dashboard') }}" class="brand">Online Book Store <span>Admin</span></a>
            @else
                <a href="{{ url('/') }}" class="brand">Online Book Store</a>
            @endif
            @if(request()->is('admin*') && !request()->is('admin/login'))
                <button type="button" class="nav-toggle" id="admin-nav-toggle" aria-label="Toggle Admin Navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="nav-links" id="admin-nav-links">
                    <li><button type="button" class="admin-nav-item active" data-target="dashboard-panel"><i class="fa-solid fa-chart-line"></i> Dashboard</button></li>
                    <li><button type="button" class="admin-nav-item" data-target="inventory-panel"><i class="fa-solid fa-book"></i> Books List</button></li>
                    <li>
                        <form action="{{ url('/admin/logout') }}" method="POST" id="admin-logout-form-nav" style="display:inline;">
                            @csrf
                            <button type="submit" class="admin-nav-logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            @elseif(!request()->is('admin*'))
                <button type="button" class="nav-toggle" id="nav-toggle" aria-label="Toggle Navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="nav-links" id="nav-links">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/books') }}">Books</a></li>
                </ul>
            @endif
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; 2026 Online Book Store. All rights reserved.</p>
    </footer>

    <script src="{{ asset('js/main.js') }}"></script>
    
    @stack('scripts')
</body>
</html>