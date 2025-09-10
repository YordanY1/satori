<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Livewire\Concerns\UsesCart;
use App\Models\Genre;
use Illuminate\Support\Str;

class GenreShow extends Component
{
    use UsesCart;

    public string $slug;
    public array $genre = [];
    public array $seo = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $genre = Genre::where('slug', $slug)
            ->with(['books' => fn($q) => $q->with('author:id,name')->latest('id')->take(24)])
            ->firstOrFail();

        $books = $genre->books->map(fn($b) => [
            'id'    => $b->id,
            'slug'  => $b->slug,
            'title' => $b->title,
            'price' => $b->price,
            'cover' => $b->cover
                ? (str_starts_with($b->cover, 'http')
                    ? $b->cover
                    : asset('storage/' . ltrim($b->cover, '/')))
                : asset('images/placeholders/book.jpg'),
            'author' => $b->author?->name,
        ])->all();


        $this->genre = [
            'name'  => $genre->name,
            'desc'  => $genre->description ?? '',
            'books' => $books,
        ];

        $this->seo = [
            'title' => $genre->name . ' — Жанр — Сатори Ко',
            'description' => Str::limit(strip_tags($genre->description ?? 'Книги от жанра ' . $genre->name), 160),
            'keywords' => $genre->name . ', книги, жанр, Сатори',
            'og:image' => $books[0]['cover'] ?? asset('images/default-og.jpg'),
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "CollectionPage",
                "name" => $genre->name . ' — Жанр — Сатори Ко',
                "description" => Str::limit(strip_tags($genre->description ?? ''), 200),
                "url" => url()->current(),
                "about" => $genre->name,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.genre-show', [
            'genre' => $this->genre,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
