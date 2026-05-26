<?php

namespace Database\Seeders;

use App\Models\ServiceItem;
use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageSeeder extends Seeder
{
    public function run(): void
    {
        ServicePage::query()->updateOrCreate(['id' => 1], [
            'section_label' => 'Our Services',
            'title' => 'Explore Our',
            'title_highlight' => 'Services',
            'is_active' => true,
        ]);

        $items = [
            ['icon' => 'fa-bed', 'title' => 'Room Accommodation', 'description' => 'Experience comfort and luxury in our well-appointed rooms with modern amenities and stunning views.', 'sort_order' => 1],
            ['icon' => 'fa-utensils', 'title' => 'Food & Beverage', 'description' => 'Enjoy world-class dining with our expert chefs preparing delicious dishes from around the globe.', 'sort_order' => 2],
            ['icon' => 'fa-dumbbell', 'title' => 'Fitness Center', 'description' => 'Stay fit during your stay with our state-of-the-art fitness facilities and professional trainers.', 'sort_order' => 3],
            ['icon' => 'fa-spa', 'title' => 'Spa & Wellness', 'description' => 'Relax and rejuvenate at our spa with therapeutic treatments and wellness programs.', 'sort_order' => 4],
            ['icon' => 'fa-swimmer', 'title' => 'Swimming Pool', 'description' => 'Enjoy refreshing swims in our Olympic-sized pool with professional lifeguard services.', 'sort_order' => 5],
            ['icon' => 'fa-concierge-bell', 'title' => 'Concierge Service', 'description' => 'Our dedicated concierge team is available 24/7 to assist with any requests or inquiries.', 'sort_order' => 6],
        ];

        foreach ($items as $item) {
            ServiceItem::updateOrCreate(
                ['title' => $item['title']],
                array_merge($item, ['is_active' => true]),
            );
        }
    }
}
