<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    public string $site_name;
    public ?string $logo_path;
    public ?string $contact_email;
    public ?string $contact_phone;
    public ?string $address;
    public ?string $facebook;
    public ?string $instagram;

    public static function group(): string
    {
        return 'site';
    }

    public static function defaults(): array
    {
        return [
            'site_name'     => 'Satori',
            'logo_path'     => null,
            'contact_email' => null,
            'contact_phone' => null,
            'address'       => null,
            'facebook'      => null,
            'instagram'     => null,
        ];
    }
}
