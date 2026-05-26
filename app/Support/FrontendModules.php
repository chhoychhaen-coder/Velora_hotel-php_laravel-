<?php

namespace App\Support;

use App\Models\Booking;
use App\Models\BookingPageImage;
use App\Models\ContactInfoItem;
use App\Models\ContactMessage;
use App\Models\FooterLink;
use App\Models\HeroSlide;
use App\Models\Room;
use App\Models\ServiceItem;
use App\Models\Testimonial;

class FrontendModules
{
    public static function overview(): array
    {
        return [
            [
                'frontend_page' => 'Home',
                'frontend_url' => route('home'),
                'frontend_display' => 'Hero slideshow (image, title, text, buttons)',
                'backend_module' => 'Home Slideshow',
                'backend_route' => 'admin.hero-slides.index',
                'backend_manage' => 'Add / edit slides, upload images, sort order',
                'count' => HeroSlide::where('is_active', true)->count(),
                'count_label' => 'active slides',
            ],
            [
                'frontend_page' => 'About',
                'frontend_url' => route('about'),
                'frontend_display' => 'Dynamic text, features, gallery images',
                'backend_module' => 'About Page',
                'backend_route' => 'admin.about-page.index',
                'backend_manage' => 'Edit paragraphs, checklist, photos',
                'count' => \App\Models\AboutFeature::where('is_active', true)->count(),
                'count_label' => 'active features',
            ],
            [
                'frontend_page' => 'Inner page banners',
                'frontend_url' => route('rooms'),
                'frontend_display' => 'Header banner images (slideshow images only)',
                'backend_module' => 'Home Slideshow',
                'backend_route' => 'admin.hero-slides.index',
                'backend_manage' => 'Uses images from active slides',
                'count' => HeroSlide::where('is_active', true)->whereNotNull('image_path')->count(),
                'count_label' => 'slides with image',
            ],
            [
                'frontend_page' => 'Services',
                'frontend_url' => route('service'),
                'frontend_display' => 'Service cards with icon, title, description',
                'backend_module' => 'Services Page',
                'backend_route' => 'admin.service-page.index',
                'backend_manage' => 'Edit header and service card list',
                'count' => ServiceItem::where('is_active', true)->count(),
                'count_label' => 'active services',
            ],
            [
                'frontend_page' => 'Rooms',
                'frontend_url' => route('rooms'),
                'frontend_display' => 'Room cards with photos and prices',
                'backend_module' => 'Rooms & Room Types',
                'backend_route' => 'admin.rooms.index',
                'backend_manage' => 'Room status, numbers, linked room type',
                'count' => Room::where('status', 'available')->count(),
                'count_label' => 'available',
            ],
            [
                'frontend_page' => 'Home & Testimonials',
                'frontend_url' => route('testimonial'),
                'frontend_display' => 'Guest review slider (approved only)',
                'backend_module' => 'Testimonials',
                'backend_route' => 'admin.testimonials.index',
                'backend_manage' => 'Approve, edit, or delete reviews',
                'count' => Testimonial::where('is_approved', true)->count(),
                'count_label' => 'approved',
            ],
            [
                'frontend_page' => 'Booking page',
                'frontend_url' => route('booking'),
                'frontend_display' => 'Left-side image gallery on booking form',
                'backend_module' => 'Booking Page',
                'backend_route' => 'admin.booking-page.index',
                'backend_manage' => 'Upload and order booking page images',
                'count' => BookingPageImage::where('is_active', true)->count(),
                'count_label' => 'active images',
            ],
            [
                'frontend_page' => 'Booking & Payment',
                'frontend_url' => route('booking'),
                'frontend_display' => 'Booking form and payment options',
                'backend_module' => 'Bookings & Payments',
                'backend_route' => 'admin.bookings.index',
                'backend_manage' => 'View paid bookings and track payments',
                'count' => Booking::paid()->count(),
                'count_label' => 'paid bookings',
            ],
            [
                'frontend_page' => 'Contact',
                'frontend_url' => route('contact'),
                'frontend_display' => 'Page header, email boxes, map embed',
                'backend_module' => 'Contact Page',
                'backend_route' => 'admin.contact-page.index',
                'backend_manage' => 'Edit contact info table and map',
                'count' => ContactInfoItem::where('is_active', true)->count(),
                'count_label' => 'active info boxes',
            ],
            [
                'frontend_page' => 'Contact form',
                'frontend_url' => route('contact'),
                'frontend_display' => 'Guest form submissions',
                'backend_module' => 'Messages',
                'backend_route' => 'admin.contact-messages.index',
                'backend_manage' => 'Read guest messages',
                'count' => ContactMessage::where('is_read', false)->count(),
                'count_label' => 'unread',
            ],
            [
                'frontend_page' => 'Site footer',
                'frontend_url' => route('home'),
                'frontend_display' => 'Brand, contact info, navigation links, social icons',
                'backend_module' => 'Footer',
                'backend_route' => 'admin.footer-page.index',
                'backend_manage' => 'Edit footer text and social links',
                'count' => FooterLink::where('group', FooterLink::GROUP_SOCIAL)->where('is_active', true)->count(),
                'count_label' => 'social links',
            ],
        ];
    }
}
