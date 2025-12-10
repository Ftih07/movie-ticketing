<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\MovieController;
use App\Http\Controllers\User\BookingController;

Route::get('/', [MovieController::class, 'index'])->name('movies.index');

// Auth (User)
Route::get('/login', [AuthController::class, 'loginForm'])->name('user.login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');

// Semua route berikut wajib user login
// Semua route berikut wajib user login
Route::middleware(['auth', 'can:customer-access'])->group(function () {

    // Pilih film
    Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

    // Booking
    Route::post('/booking/{movie}', [BookingController::class, 'store'])->name('booking.store');

    // Halaman tiket + QR setelah booking
    Route::get('/booking/{booking}/ticket', [BookingController::class, 'ticket'])->name('booking.ticket');

    // History user
    Route::get('/my-tickets', [BookingController::class, 'history'])->name('booking.history');
});
