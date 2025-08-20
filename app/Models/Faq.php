<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['question', 'answer', 'tags', 'is_active'];

    public function scopeSearch($q, $term)
    {
        if (!trim($term)) return $q->where('is_active', true);
        $term = "%" . mb_strtolower($term) . "%";
        return $q->where('is_active', true)->where(function ($qq) use ($term) {
            $qq->whereRaw('LOWER(question) LIKE ?', [$term])
                ->orWhereRaw('LOWER(answer) LIKE ?', [$term])
                ->orWhereRaw('LOWER(tags) LIKE ?', [$term]);
        });
    }
}
