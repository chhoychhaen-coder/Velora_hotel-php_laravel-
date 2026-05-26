<?php

namespace App\Models;

use App\Helpers\HotelAssets;
use App\Helpers\ImageStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class WebsiteContent extends Model
{
    protected $fillable = [
        'page',
        'section_key',
        'label',
        'title',
        'body',
        'image_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function imageUrl(string $page, string $sectionKey, string $fallback = 'hero.jpg'): string
    {
        $content = static::query()
            ->where('page', $page)
            ->where('section_key', $sectionKey)
            ->where('is_active', true)
            ->first();

        if ($content?->image_path) {
            return ImageStorage::url($content->image_path) ?? HotelAssets::url($fallback);
        }

        return HotelAssets::url($fallback);
    }

    public static function upsertImage(string $page, string $sectionKey, UploadedFile $file, string $label): self
    {
        $content = static::firstOrNew([
            'page' => $page,
            'section_key' => $sectionKey,
        ]);

        if ($content->image_path) {
            ImageStorage::delete($content->image_path);
        }

        $content->fill([
            'label' => $label,
            'title' => $label,
            'image_path' => ImageStorage::store($file, 'site-images'),
            'is_active' => true,
        ])->save();

        return $content;
    }
}
