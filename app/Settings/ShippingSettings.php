<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ShippingSettings extends Settings
{
    public string $sender_name;
    public string $sender_phone;
    public string $sender_city;
    public string $sender_post;
    public string $sender_street;
    public string $sender_num;

    public string $econt_env;  // 'test' | 'production'
    public string $econt_user;
    public string $econt_pass;

    public static function group(): string
    {
        return 'shipping';
    }

    public static function defaults(): array
    {
        return [
            'sender_name'   => '',
            'sender_phone'  => '',
            'sender_city'   => '',
            'sender_post'   => '',
            'sender_street' => '',
            'sender_num'    => '',
            'econt_env'     => 'test',
            'econt_user'    => '',
            'econt_pass'    => '',
        ];
    }
}
