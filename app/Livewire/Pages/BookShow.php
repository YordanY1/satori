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

    protected $listeners = ['review:created' => 'reloadReviews'];

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $b = Book::query()
            ->where('slug', $slug)
            ->with([
                'author:id,name,slug',
                'reviews' => fn($q) => $q->latest(),
            ])
            ->firstOrFail();

        $cover = $b->cover
            ? (Str::startsWith($b->cover, ['http://', 'https://'])
                ? $b->cover
                : asset('storage/' . ltrim($b->cover, '/')))
            : asset('storage/images/default-book.jpg');

        $excerptUrl = $b->excerpt
            ? (Str::startsWith($b->excerpt, ['http://', 'https://'])
                ? $b->excerpt
                : asset('storage/' . ltrim($b->excerpt, '/')))
            : null;

        $reviews = $b->reviews->map(fn($r) => [
            'user'    => $r->user_name ?: 'Анонимен',
            'rating'  => (int) $r->rating,
            'content' => (string) ($r->content ?? ''),
        ])->toArray();

        $ratingAvg = (float) number_format($b->reviews()->avg('rating') ?? 0, 1);
        $ratingCnt = (int) $b->reviews()->count();

        $this->book = [
            'id'           => $b->id,
            'slug'         => $b->slug,
            'title'        => $b->title,
            'author'       => [
                'name' => $b->author->name,
                'slug' => $b->author->slug,
            ],
            'price'        => (float) $b->price,
            'price_eur'    => (float) $b->price_eur,
            'format'       => (string) $b->format,
            'cover'        => $cover,
            'description'  => (string) ($b->description ?? ''),
            'excerpt_url'  => $excerptUrl,
            'rating_avg'   => $ratingAvg,
            'rating_count' => $ratingCnt,
            'reviews'      => $reviews,
        ];
    }


    public function reloadReviews(): void
    {
        $b = Book::with(['reviews' => fn($q) => $q->latest()])
            ->findOrFail($this->book['id']);

        $reviews = $b->reviews->map(fn($r) => [
            'user'    => $r->user_name ?: 'Анонимен',
            'rating'  => (int) $r->rating,
            'content' => (string) ($r->content ?? ''),
        ])->toArray();

        $avg = (float) number_format($b->reviews()->avg('rating') ?? 0, 1);
        $cnt = (int) $b->reviews()->count();

        $this->book['reviews'] = $reviews;
        $this->book['rating_avg'] = $avg;
        $this->book['rating_count'] = $cnt;
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
