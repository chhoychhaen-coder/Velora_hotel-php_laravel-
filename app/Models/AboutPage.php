<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'section_label',
        'title',
        'title_highlight',
        'paragraph_one',
        'paragraph_two',
        'button_label',
        'button_link',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'section_label' => 'About Us',
            'title' => 'Welcome to',
            'title_highlight' => 'Velora Hotel',
            'paragraph_one' => 'Velora Hotel is a premier luxury hotel designed to provide world-class accommodation and services.',
            'paragraph_two' => 'Our dedicated team is committed to ensuring every guest enjoys their stay with us.',
            'button_label' => 'Explore More',
            'button_link' => '/booking',
            'is_active' => true,
        ]);
    }

    public function buttonUrl(): string
    {
        $link = $this->button_link ?: '/booking';

        if (str_starts_with($link, 'http://') || str_starts_with($link, 'https://')) {
            return $link;
        }

        return url('/' . ltrim($link, '/'));
    }
}
