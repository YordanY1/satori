<?php

use App\Settings\{SiteSettings, SeoSettings, PaymentSettings, ShippingSettings};

return [
    'settings' => [
        SiteSettings::class,
        SeoSettings::class,
        PaymentSettings::class,
        ShippingSettings::class,
    ],
];
