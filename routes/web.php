<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Admin\AdminBookController;
use Illuminate\Support\Facades\Auth;

// Public Client Routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);

// Admin Authentication
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        session(['admin_logged_in' => true]);
        return redirect('/admin/dashboard');
    }

    return back()->withErrors(['msg' => 'Sorry, your email or password is incorrect!']);
});

Route::post('/admin/logout', function () {
    session()->forget('admin_logged_in');
    return redirect('/admin/login');
});

// Protected Admin Panel & CRUD Routes
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminBookController::class, 'dashboard']);
    Route::get('/admin/books/create', [AdminBookController::class, 'create']);
    Route::post('/admin/books', [AdminBookController::class, 'store']);
    Route::get('/admin/books/{id}/edit', [AdminBookController::class, 'edit']);
    Route::put('/admin/books/{id}', [AdminBookController::class, 'update']);
    Route::delete('/admin/books/{id}', [AdminBookController::class, 'destroy']);
});