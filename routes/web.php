<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

// Public Flight Pages (user)
Route::get('/flights', [FlightController::class,'index'])->name('flights.index');
Route::get('/flights/{id}', [FlightController::class,'show'])->name('flights.show');

// Bookings (Only Logged In Users)
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{flightId}', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// ADMIN (auth + admin middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Flights admin
    Route::get('/admin/flights', [AdminController::class, 'index'])->name('admin.flights');
    Route::get('/admin/flights/create', [AdminController::class, 'createFlight'])->name('admin.flights.create');
    Route::post('/admin/flights', [AdminController::class, 'store'])->name('admin.flights.store');

    // Cancel / restore flights (soft cancel)
    Route::post('/admin/flights/{id}/cancel', [AdminController::class, 'cancelFlight'])->name('admin.flights.cancel');
    Route::post('/admin/flights/{id}/restore', [AdminController::class, 'restoreFlight'])->name('admin.flights.restore');

    // Admin bookings (no update)
    Route::get('/admin/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::delete('/admin/bookings/{id}', [AdminController::class, 'deleteBooking'])->name('admin.bookings.delete');
    Route::post('/admin/bookings/{id}/success', [AdminController::class, 'markSuccess'])->name('admin.bookings.success');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
