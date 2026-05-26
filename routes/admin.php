<?php

use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\BookingPageController;
use App\Http\Controllers\Admin\ContactPageController;
use App\Http\Controllers\Admin\FooterPageController;
use App\Http\Controllers\Admin\ServicePageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\HeroSlideController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/bank-transfers', [DashboardController::class, 'updateBankTransfer'])->name('bank-transfers.update');
        Route::delete('/bank-transfers/{bankTransfer}', [DashboardController::class, 'destroyBankTransfer'])->name('bank-transfers.destroy');
        Route::redirect('/', '/admin/dashboard')->name('index');
        Route::get('/calendar', [DashboardController::class, 'calendar'])->name('calendar');
        Route::get('/booked-rooms', [DashboardController::class, 'bookedRooms'])->name('booked-rooms');
        Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
        Route::resource('rooms', RoomController::class);
        Route::resource('room-types', RoomTypeController::class);
        Route::resource('bookings', BookingController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('users', UserController::class);
        Route::resource('contact-messages', ContactMessageController::class);
        Route::resource('testimonials', TestimonialController::class);
        Route::resource('hero-slides', HeroSlideController::class);
        Route::get('about-page', [AboutPageController::class, 'index'])->name('about-page.index');
        Route::put('about-page', [AboutPageController::class, 'updateContent'])->name('about-page.update');
        Route::post('about-features', [AboutPageController::class, 'storeFeature'])->name('about-features.store');
        Route::put('about-features/{aboutFeature}', [AboutPageController::class, 'updateFeature'])->name('about-features.update');
        Route::delete('about-features/{aboutFeature}', [AboutPageController::class, 'destroyFeature'])->name('about-features.destroy');
        Route::post('about-gallery', [AboutPageController::class, 'storeGalleryImage'])->name('about-gallery.store');
        Route::put('about-gallery/{aboutGalleryImage}', [AboutPageController::class, 'updateGalleryImage'])->name('about-gallery.update');
        Route::delete('about-gallery/{aboutGalleryImage}', [AboutPageController::class, 'destroyGalleryImage'])->name('about-gallery.destroy');
        Route::get('service-page', [ServicePageController::class, 'index'])->name('service-page.index');
        Route::put('service-page', [ServicePageController::class, 'updateContent'])->name('service-page.update');
        Route::post('service-items', [ServicePageController::class, 'storeItem'])->name('service-items.store');
        Route::put('service-items/{serviceItem}', [ServicePageController::class, 'updateItem'])->name('service-items.update');
        Route::delete('service-items/{serviceItem}', [ServicePageController::class, 'destroyItem'])->name('service-items.destroy');
        Route::get('booking-page', [BookingPageController::class, 'index'])->name('booking-page.index');
        Route::post('booking-page-images', [BookingPageController::class, 'storeImage'])->name('booking-page-images.store');
        Route::put('booking-page-images/{bookingPageImage}', [BookingPageController::class, 'updateImage'])->name('booking-page-images.update');
        Route::delete('booking-page-images/{bookingPageImage}', [BookingPageController::class, 'destroyImage'])->name('booking-page-images.destroy');
        Route::get('contact-page', [ContactPageController::class, 'index'])->name('contact-page.index');
        Route::put('contact-page', [ContactPageController::class, 'updateContent'])->name('contact-page.update');
        Route::post('contact-info-items', [ContactPageController::class, 'storeItem'])->name('contact-info-items.store');
        Route::put('contact-info-items/{contactInfoItem}', [ContactPageController::class, 'updateItem'])->name('contact-info-items.update');
        Route::delete('contact-info-items/{contactInfoItem}', [ContactPageController::class, 'destroyItem'])->name('contact-info-items.destroy');
        Route::get('footer-page', [FooterPageController::class, 'index'])->name('footer-page.index');
        Route::put('footer-page', [FooterPageController::class, 'updateContent'])->name('footer-page.update');
        Route::post('footer-links', [FooterPageController::class, 'storeLink'])->name('footer-links.store');
        Route::put('footer-links/{footerLink}', [FooterPageController::class, 'updateLink'])->name('footer-links.update');
        Route::delete('footer-links/{footerLink}', [FooterPageController::class, 'destroyLink'])->name('footer-links.destroy');
    });
