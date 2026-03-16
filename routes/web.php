<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchedContentController;
use Illuminate\Support\Facades\Route;

// Landing page (public)
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/support', function () {
    return view('support');
})->name('support');

// Guest routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Google SSO
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
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

    // Payment Methods
    Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('payment.index');
    Route::post('/payment-methods', [PaymentMethodController::class, 'store'])->name('payment.store');
    Route::delete('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('payment.destroy');

    // Security & Settings
    Route::get('/settings', [SecurityController::class, 'index'])->name('settings.index');
    Route::get('/settings/email', [SecurityController::class, 'editEmail'])->name('settings.email');
    Route::put('/settings/email', [SecurityController::class, 'updateEmail'])->name('settings.email.update');
    Route::get('/settings/mobile', [SecurityController::class, 'editMobile'])->name('settings.mobile');
    Route::put('/settings/mobile', [SecurityController::class, 'updateMobile'])->name('settings.mobile.update');
    Route::get('/settings/password', [SecurityController::class, 'editPassword'])->name('settings.password');
    Route::put('/settings/password', [SecurityController::class, 'updatePassword'])->name('settings.password.update');
    Route::get('/settings/devices', [SecurityController::class, 'devices'])->name('settings.devices');
    Route::delete('/settings/devices/{session}', [SecurityController::class, 'destroySession'])->name('settings.session.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // Bookings Management (Current & Previous)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}/detail', [BookingController::class, 'fetchAgodaDetail'])->name('bookings.detail');
    Route::post('/bookings/sync', [BookingController::class, 'storeAgodaBooking'])->name('bookings.sync');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{booking}/amend', [BookingController::class, 'editAmendment'])->name('bookings.amend');
    Route::patch('/bookings/{booking}/amend', [BookingController::class, 'submitAmendment'])->name('bookings.amend.submit');

    // Booking & Checkout
    // Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/booking/process', [BookingController::class, 'processBookingPayment'])->name('booking.process');
    Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
});

Route::controller(SearchedContentController::class)->group(function () {
    Route::get('/searched', 'index')->name('searched.index');
    Route::post('/searched', 'store')->name('searched.store');
});

// BitPay IPN Callback (no auth required)
Route::post('/booking/bitpay/callback', [BookingController::class, 'bitpayCallback'])->name('booking.bitpay.callback');
