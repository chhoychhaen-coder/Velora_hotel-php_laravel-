<?php

namespace Database\Seeders;

use App\Models\AboutFeature;
use App\Models\AboutGalleryImage;
use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        AboutPage::query()->updateOrCreate(['id' => 1], [
            'section_label' => 'About Us',
            'title' => 'Welcome to',
            'title_highlight' => 'Velora Hotel',
            'paragraph_one' => 'Velora Hotel is a premier luxury hotel management system designed to provide world-class accommodation and services. With years of experience in hospitality, we pride ourselves on delivering exceptional customer experiences.',
            'paragraph_two' => 'Our dedicated team of professionals is committed to ensuring every guest enjoys their stay with us. From elegant rooms to top-notch facilities, we have everything to make your stay memorable.',
            'button_label' => 'Explore More',
            'button_link' => '/booking',
            'is_active' => true,
        ]);

        $features = [
            ['title' => 'Premium Room Options', 'sort_order' => 1],
            ['title' => '24/7 Customer Support', 'sort_order' => 2],
            ['title' => 'Modern Amenities & Facilities', 'sort_order' => 3],
        ];

        foreach ($features as $feature) {
            AboutFeature::updateOrCreate(
                ['title' => $feature['title']],
                array_merge($feature, ['is_active' => true]),
            );
        }

        $images = [
            ['sort_order' => 1, 'size_class' => 'w-75', 'align_class' => 'text-end', 'extra_style' => 'margin-top: 25%;'],
            ['sort_order' => 2, 'size_class' => 'w-100', 'align_class' => 'text-start', 'extra_style' => null],
            ['sort_order' => 3, 'size_class' => 'w-50', 'align_class' => 'text-end', 'extra_style' => null],
            ['sort_order' => 4, 'size_class' => 'w-75', 'align_class' => 'text-start', 'extra_style' => null],
        ];

        foreach ($images as $image) {
            AboutGalleryImage::updateOrCreate(
                ['sort_order' => $image['sort_order']],
                array_merge($image, ['is_active' => true]),
            );
        }
    }
}
