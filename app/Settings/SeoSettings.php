<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SeoSettings extends Settings
{
    public ?string $meta_title;
    public ?string $meta_description;
    public ?string $og_image;

    public static function group(): string
    {
        return 'seo';
    }

    public static function defaults(): array
    {
        return [
            'meta_title'       => null,
            'meta_description' => null,
            'og_image'         => null,
        ];
    }
}
