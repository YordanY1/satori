<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'shipping_draft'  => 'array',
        'shipping_payload' => 'array',
        'paid_at'         => 'datetime',
    ];

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullShippingAddressAttribute(): string
    {
        $draft = (array) $this->shipping_draft;
        $receiver = data_get($draft, 'receiver', []);
        $method = data_get($draft, 'method');

        if ($method === 'econt_office') {
            $officeCode = data_get($draft, 'receiver_office_code');
            if ($officeCode) {
                return 'Офис на Еконт: ' . $officeCode;
            }
        }

        if ($method === 'address') {
            $parts = [];

            if (!empty($receiver['street_label'])) {
                $parts[] = $receiver['street_label'];
            }

            if (!empty($receiver['street_num'])) {
                $parts[] = '№ ' . $receiver['street_num'];
            }

            if (!empty($receiver['city_id']) && class_exists(\Gdinko\Econt\Models\CarrierEcontCity::class)) {
                $city = \Gdinko\Econt\Models\CarrierEcontCity::find($receiver['city_id']);
                if ($city) {
                    $parts[] = $city->name;
                    if (!empty($city->post_code)) {
                        $parts[] = 'ПК ' . $city->post_code;
                    }
                }
            }

            if (!empty($this->customer_address)) {
                $parts[] = $this->customer_address;
            }

            if (!empty($parts)) {
                return implode(', ', $parts);
            }
        }

        return $this->customer_address ?: '—';
    }
}
