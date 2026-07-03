<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Book Store</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;800&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>
<body>
    <div class="login-container">
        
        <div class="login-header">
            <a href="{{ url('/') }}" class="btn-back-home"><i class="fa-solid fa-arrow-left"></i> Back to Bookstore</a>
        </div>

        <div class="login-card">
            <div class="card-brand">
                <span class="card-brand-icon"><i class="fa-solid fa-book-bookmark"></i></span>
                <h1>Admin Portal</h1>
                <p>Sign in to manage your bookstore catalog.</p>
            </div>
            
            @if($errors->any())
                <div class="error-alert">
                    <span class="error-icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ url('/admin/login') }}" method="POST" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required placeholder="admin@example.com" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn-login"><i class="fa-solid fa-right-to-bracket"></i> Login to Dashboard</button>
            </form>
        </div>
    </div>
</body>
</html>