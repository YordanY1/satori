<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Livewire\Concerns\UsesCart;
use App\Models\Genre;

class GenreShow extends Component
{
    use UsesCart;

    public string $slug;
    public array $genre = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $genre = Genre::where('slug', $slug)->firstOrFail();

        $books = $genre->books()
            ->with('author:id,name')
            ->select(
                'books.id',
                'books.author_id',
                'books.title',
                'books.slug',
                'books.price',
                'books.cover'
            )
            ->latest('books.id')
            ->take(24)
            ->get()
            ->map(fn($b) => [
                'id'    => $b->id,
                'slug'  => $b->slug,
                'title' => $b->title,
                'price' => $b->price,
                'cover' => $b->cover
                    ? (str_starts_with($b->cover, 'storage/')
                        ? asset($b->cover)
                        : asset('storage/' . ltrim($b->cover, '/')))
                    : asset('images/placeholders/book.jpg'),

            ])
            ->all();

        $this->genre = [
            'name'  => $genre->name,
            'desc'  => $genre->description ?? '',
            'books' => $books,
        ];
    }

    public function render()
    {
        return view('livewire.pages.genre-show', [
            'genre' => $this->genre,
        ])->layout('layouts.app', [
            'title' => $this->genre['name'] . ' — Жанр — Сатори Ко',
        ]);
    }
}
