<?php

namespace Database\Seeders;

use App\Models\FooterLink;
use App\Models\FooterSetting;
use Illuminate\Database\Seeder;

class FooterPageSeeder extends Seeder
{
    public function run(): void
    {
        FooterSetting::query()->updateOrCreate(['id' => 1], [
            'brand_name' => 'Velora Hotel',
            'tagline' => 'Comfortable rooms, simple booking, and responsive service for every guest.',
            'company_section_title' => 'Company',
            'guest_section_title' => 'Guest',
            'contact_section_title' => 'Contact',
            'address' => '123 Street, New York, USA',
            'phone' => '+012 345 67890',
            'email' => 'info@velorahotel.com',
            'copyright_text' => 'Velora Hotel. All rights reserved.',
            'is_active' => true,
        ]);

        $socialLinks = [
            ['label' => 'Facebook', 'url' => '#', 'icon' => 'fa-facebook-f', 'sort_order' => 1],
            ['label' => 'Twitter', 'url' => '#', 'icon' => 'fa-twitter', 'sort_order' => 2],
            ['label' => 'Instagram', 'url' => '#', 'icon' => 'fa-instagram', 'sort_order' => 3],
        ];

        foreach ($socialLinks as $link) {
            FooterLink::updateOrCreate(
                ['group' => FooterLink::GROUP_SOCIAL, 'label' => $link['label']],
                array_merge($link, ['group' => FooterLink::GROUP_SOCIAL, 'is_active' => true]),
            );
        }
    }
}
