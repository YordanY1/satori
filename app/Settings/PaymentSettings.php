<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PaymentSettings extends Settings
{
    public ?string $stripe_public_key;
    public ?string $stripe_secret_key;
    public ?string $stripe_webhook_secret;
    public string $currency;

    public static function group(): string
    {
        return 'payment';
    }

    public static function defaults(): array
    {
        return [
            'stripe_public_key'    => null,
            'stripe_secret_key'    => null,
            'stripe_webhook_secret'=> null,
            'currency'             => 'BGN',
        ];
    }
}
