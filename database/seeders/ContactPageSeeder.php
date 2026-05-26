<?php

namespace Database\Seeders;

use App\Models\ContactInfoItem;
use App\Models\ContactPage;
use Illuminate\Database\Seeder;

class ContactPageSeeder extends Seeder
{
    public function run(): void
    {
        ContactPage::query()->updateOrCreate(['id' => 1], [
            'section_label' => 'Contact Us',
            'title' => 'Contact',
            'title_highlight' => 'For Any Query',
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd',
            'is_active' => true,
        ]);

        $items = [
            ['title' => 'Booking', 'email' => 'book@velorahotel.com', 'sort_order' => 1],
            ['title' => 'General', 'email' => 'info@velorahotel.com', 'sort_order' => 2],
            ['title' => 'Technical', 'email' => 'tech@velorahotel.com', 'sort_order' => 3],
        ];

        foreach ($items as $item) {
            ContactInfoItem::updateOrCreate(
                ['title' => $item['title']],
                array_merge($item, ['is_active' => true]),
            );
        }
    }
}
