<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'float',
        'weight' => 'float',
        'is_book_of_month' => 'bool',
        'is_recommended' => 'bool',
    ];

    protected $table = 'books';


    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(\App\Models\Favorite::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(\App\Models\User::class, 'favorites')->withTimestamps();
    }

    public function isFavoritedBy(?\App\Models\User $user): bool
    {
        if (! $user) return false;
        return $this->favoritedBy()->where('users.id', $user->id)->exists();
    }

    public function getCoverUrlAttribute(): string
    {
        if (Str::startsWith($this->cover, ['http://', 'https://'])) {
            return $this->cover;
        }

        return asset('storage/' . ($this->cover ?? 'images/default-book.jpg'));
    }
}
