<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    public function scopeActive($q)
    {
        return $q->whereNotNull('confirmed_at')->whereNull('unsubscribed_at');
    }
}
