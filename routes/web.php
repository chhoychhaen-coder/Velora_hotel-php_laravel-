<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::get('/assets/front.css', function () {
    $path = resource_path('css/front.css');
    abort_unless(is_file($path), 404);

    return response()->file($path, [
        'Content-Type' => 'text/css; charset=UTF-8',
        'Cache-Control' => 'public, max-age=3600',
    ]);
})->name('assets.front.css');

// Frontend Routes - Dynamic from Backend
Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/service', [FrontController::class, 'service'])->name('service');
Route::get('/rooms', [FrontController::class, 'rooms'])->name('rooms');
Route::get('/rooms/{room}', [FrontController::class, 'roomDetails'])->name('rooms.show');
Route::get('/booking', [FrontController::class, 'booking'])->middleware('auth')->name('booking');
Route::post('/bookings', [BookingController::class, 'storeGuest'])->middleware('auth')->name('bookings.store');
Route::get('/booking/payment', [BookingController::class, 'showPayment'])->middleware('auth')->name('bookings.payment.show');
Route::post('/booking/payment', [BookingController::class, 'storePayment'])->middleware('auth')->name('bookings.payment.store');
Route::get('/team', [FrontController::class, 'team'])->name('team');
Route::get('/testimonial', [FrontController::class, 'testimonial'])->name('testimonial');

// Contact Routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine');
    Route::get('/my-bookings/{booking}', [BookingController::class, 'showCustomerBooking'])->name('bookings.mine.show');
    Route::patch('/my-bookings/{booking}/cancel', [BookingController::class, 'cancelMine'])->name('bookings.mine.cancel');
    Route::post('/testimonials', [TestimonialController::class, 'storeCustomer'])->name('testimonials.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
