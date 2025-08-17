<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorLink extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }
    public function scopeOrdered($q)
    {
        return $q->orderBy('position')->orderBy('id');
    }
}
