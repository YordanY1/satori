<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
    public function quotes()
    {
        return $this->hasMany(AuthorQuote::class);
    }
    public function links()
    {
        return $this->hasMany(AuthorLink::class);
    }
    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
