<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\MovieController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\ProfileController;

// Home - List Film
Route::get('/', [MovieController::class, 'index'])->name('movies.index');

// Pilih film
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Auth - Login (User)
Route::get('/login', [AuthController::class, 'loginForm'])->name('user.login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'registerForm'])->name('user.register');
Route::post('/register', [AuthController::class, 'register']);

// Google Auth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('user.login.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');

// Semua route berikut wajib user login
Route::middleware(['auth', 'can:customer-access'])->group(function () {

    // Booking
    Route::post('/booking/{movie}', [BookingController::class, 'store'])->name('booking.store');

    // Halaman tiket + QR setelah booking
    Route::get('/booking/{booking}/ticket', [BookingController::class, 'ticket'])->name('booking.ticket');

    // History user
    Route::get('/my-tickets', [BookingController::class, 'history'])->name('booking.history');

    // Menampilkan form edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Memproses update data
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// routes/web.php
use App\Models\Booking;

Route::get('/validate-ticket', function () {
    return view('ticket.validate');
});

Route::post('/validate-ticket', function () {
    $ticket = request('ticket');

    $booking = Booking::where('ticket_code', $ticket)->first();

    if (! $booking) {
        return back()->with('error', 'Tiket tidak ditemukan.');
    }

    return back()->with('booking', $booking);
});
