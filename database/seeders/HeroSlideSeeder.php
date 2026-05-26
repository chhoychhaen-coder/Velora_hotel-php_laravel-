<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'kicker' => 'Velora Hotel',
                'title' => 'Comfortable stays, made simple',
                'body' => 'Browse rooms, book online, and enjoy a calm modern stay from check-in to check-out.',
                'primary_button_label' => 'Explore Rooms',
                'primary_button_link' => '/rooms',
                'secondary_button_label' => 'Book Now',
                'secondary_button_link' => '/booking',
                'sort_order' => 1,
            ],
            [
                'kicker' => 'Premium Comfort',
                'title' => 'Rooms designed for rest',
                'body' => 'Modern amenities, quiet spaces, and flexible booking for every type of guest.',
                'primary_button_label' => 'View Rooms',
                'primary_button_link' => '/rooms',
                'secondary_button_label' => 'Book Now',
                'secondary_button_link' => '/booking',
                'sort_order' => 2,
            ],
            [
                'kicker' => 'Velora Hotel',
                'title' => 'Your stay starts here',
                'body' => 'Reserve in minutes and enjoy attentive service from arrival to checkout.',
                'primary_button_label' => 'Book Your Stay',
                'primary_button_link' => '/booking',
                'secondary_button_label' => 'Contact Us',
                'secondary_button_link' => '/contact',
                'sort_order' => 3,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(
                ['title' => $slide['title']],
                array_merge($slide, ['is_active' => true]),
            );
        }
    }
}
