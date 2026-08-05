<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;

// Public Parking Index & Detail Routes
Route::get('/', [ParkingController::class, 'index'])->name('parking.index');
Route::get('/parking/{id}', [ParkingController::class, 'show'])->name('parking.show');
Route::get('/bookings/confirmation/{reference}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');

// Authentication Routes for Guests
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes (Driver must be logged in to book & view bookings)
Route::middleware('auth')->group(function () {
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/my-bookings', [AuthController::class, 'myBookings'])->name('my.bookings');
});
