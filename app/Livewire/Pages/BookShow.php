<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Book;
use Illuminate\Support\Str;
use App\Livewire\Concerns\UsesCart;

class BookShow extends Component
{
    use UsesCart;

    public string $slug;
    public array $book = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $b = Book::query()
            ->where('slug', $slug)
            ->with([
                'author:id,name,slug',
                'reviews.user:id,name',
            ])
            ->firstOrFail();

        // cover
        $cover = $b->cover
            ? (Str::startsWith($b->cover, ['http://', 'https://']) ? $b->cover : asset($b->cover))
            : asset('storage/images/default-book.jpg');

        // excerpt
        $excerptUrl = $b->excerpt
            ? (Str::startsWith($b->excerpt, ['http://', 'https://']) ? $b->excerpt : asset($b->excerpt))
            : null;

        // reviews
        $reviews = $b->reviews->map(fn($r) => [
            'user'    => $r->user?->name ?? 'Анонимен',
            'rating'  => $r->rating,
            'content' => $r->content,
        ])->toArray();

        $this->book = [
            'id'           => $b->id,
            'slug'         => $b->slug,
            'title'        => $b->title,
            'author'       => [
                'name' => $b->author->name,
                'slug' => $b->author->slug,
            ],
            'price'        => (float) $b->price,
            'format'       => $b->format,
            'cover'        => $cover,
            'description'  => $b->description ?? '',
            'excerpt_url'  => $excerptUrl,
            'rating_avg'   => round($b->reviews_avg_rating ?? 0, 1),
            'rating_count' => $b->reviews_count ?? 0,
            'reviews'      => $reviews,
        ];
    }

    public function render()
    {
        return view('livewire.pages.book-show', [
            'book' => $this->book,
        ])->layout('layouts.app', [
            'title' => $this->book['title'] . ' — Сатори Ко',
        ]);
    }
}
