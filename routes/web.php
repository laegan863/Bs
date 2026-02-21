<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchedContentController;
use Illuminate\Support\Facades\Route;

// Landing page (public)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Guest routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
// Search (public)
Route::get('search', [SearchController::class, 'search'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Security & Settings
    Route::get('/settings', [SecurityController::class, 'index'])->name('settings.index');
    Route::get('/settings/email', [SecurityController::class, 'editEmail'])->name('settings.email');
    Route::put('/settings/email', [SecurityController::class, 'updateEmail'])->name('settings.email.update');
    Route::get('/settings/mobile', [SecurityController::class, 'editMobile'])->name('settings.mobile');
    Route::put('/settings/mobile', [SecurityController::class, 'updateMobile'])->name('settings.mobile.update');
    Route::get('/settings/password', [SecurityController::class, 'editPassword'])->name('settings.password');
    Route::put('/settings/password', [SecurityController::class, 'updatePassword'])->name('settings.password.update');
    Route::get('/settings/devices', [SecurityController::class, 'devices'])->name('settings.devices');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Booking & Checkout
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/booking/process', [BookingController::class, 'processPayment'])->name('booking.process');
    Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
});

Route::controller(SearchedContentController::class)->group(function () {
    Route::get('/searched', 'index')->name('searched.index');
    Route::post('/searched', 'store')->name('searched.store');
});

// BitPay IPN Callback (no auth required)
Route::post('/booking/bitpay/callback', [BookingController::class, 'bitpayCallback'])->name('booking.bitpay.callback');
