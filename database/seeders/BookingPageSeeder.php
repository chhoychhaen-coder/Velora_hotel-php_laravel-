<?php

namespace Database\Seeders;

use App\Models\BookingPageImage;
use Illuminate\Database\Seeder;

class BookingPageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            ['sort_order' => 1, 'size_class' => 'w-75', 'align_class' => 'text-end', 'extra_style' => 'margin-top: 25%;'],
            ['sort_order' => 2, 'size_class' => 'w-100', 'align_class' => 'text-start', 'extra_style' => null],
            ['sort_order' => 3, 'size_class' => 'w-50', 'align_class' => 'text-end', 'extra_style' => null],
            ['sort_order' => 4, 'size_class' => 'w-75', 'align_class' => 'text-start', 'extra_style' => null],
        ];

        foreach ($images as $image) {
            BookingPageImage::updateOrCreate(
                ['sort_order' => $image['sort_order']],
                array_merge($image, ['is_active' => true]),
            );
        }
    }
}
