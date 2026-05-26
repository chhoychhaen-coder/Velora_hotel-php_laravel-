<?php

namespace App\Helpers;

class HotelAssets
{
    public static function url(string $name): string
    {
        $themePath = public_path('fronend/hotelier-1.0.0/img/' . $name);

        if (is_file($themePath)) {
            return asset('fronend/hotelier-1.0.0/img/' . $name);
        }

        $path = public_path('images/hotel/' . $name);

        if (is_file($path)) {
            return asset('images/hotel/' . $name);
        }

        if (preg_match('/^about-(\d+)\.jpg$/', $name, $matches)) {
            $index = max(1, min(4, (int) $matches[1]));

            return 'https://picsum.photos/seed/velora-about-' . $index . '/600/450';
        }

        if (preg_match('/^(team|testimonial)-(\d+)\.jpg$/', $name, $matches)) {
            return self::url('room-' . ((intval($matches[2]) % 3) ?: 3) . '.jpg');
        }

        return match ($name) {
            'hero.jpg', 'carousel-2.jpg' => 'https://picsum.photos/1920/1080',
            'room-1.jpg' => 'https://picsum.photos/900/675?random=10',
            'room-2.jpg' => 'https://picsum.photos/900/675?random=11',
            'room-3.jpg' => 'https://picsum.photos/900/675?random=12',
            default => 'https://picsum.photos/900/675?random=10',
        };
    }

    public static function roomImage(?string $imageUrl, int $index = 0): string
    {
        return ImageStorage::url($imageUrl) ?? self::url('room-' . (($index % 3) + 1) . '.jpg');
    }
}
