<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'date',
        'location',
        'program',
        'is_paid',
        'payment_link',
        'registration_link',
        'video_url',
        'cover',
    ];
}
