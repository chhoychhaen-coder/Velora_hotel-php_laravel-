<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
    protected $fillable = [
        'section_label',
        'title',
        'title_highlight',
        'map_embed_url',
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
            'section_label' => 'Contact Us',
            'title' => 'Contact',
            'title_highlight' => 'For Any Query',
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd',
            'is_active' => true,
        ]);
    }

    public static function defaultMapEmbedUrl(): string
    {
        return 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd';
    }

    public function mapUrl(): string
    {
        return static::normalizeMapEmbedUrl($this->map_embed_url) ?? static::defaultMapEmbedUrl();
    }

    public static function normalizeMapEmbedUrl(?string $input): ?string
    {
        $value = trim(html_entity_decode((string) $input));

        if ($value === '') {
            return null;
        }

        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $value, $matches)) {
            $value = $matches[1];
        }

        if (preg_match('/src=["\']([^"\']+)["\']/i', $value, $matches)) {
            $value = $matches[1];
        }

        $value = trim($value);

        if (str_contains($value, 'google.com/maps/embed') || str_contains($value, 'maps.google.com/maps')) {
            return $value;
        }

        // Short/share links cannot be used inside an iframe.
        if (preg_match('#maps\.app\.goo\.gl|goo\.gl/maps#i', $value)) {
            return null;
        }

        if (preg_match('#google\.com/maps|maps\.google\.com#i', $value) && ! str_contains($value, '/embed')) {
            return null;
        }

        return filter_var($value, FILTER_VALIDATE_URL) ? $value : null;
    }
}
