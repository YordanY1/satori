<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Support\Str;
use App\Livewire\Concerns\UsesCart;

class Catalog extends Component
{
    use WithPagination;
    use UsesCart;

    public array $filters = [
        'author' => null,
        'genre'  => null,
        'format' => null,
        'price'  => null,
    ];

    public string $sort = 'popular';

    public $authorOptions = [];
    public $genreOptions  = [];
    public array $seo = [];

    protected $queryString = [
        'filters',
        'sort' => ['except' => 'popular'],
        'page' => ['except' => 1],
    ];

    public function mount(): void
    {
        $this->authorOptions = Author::orderBy('name')->get(['id', 'name']);
        $this->genreOptions  = Genre::orderBy('name')->get(['id', 'name', 'slug']);

        $this->seo = [
            'title' => 'Каталог — Сатори Ко',
            'description' => 'Разгледай пълния каталог на Сатори Ко. Книги по жанрове, автори и формати. Литература, духовност, философия и още.',
            'keywords' => 'сатори, каталог, книги, автори, жанрове, литература',
            'og:image' => asset('images/og/catalog.jpg'),
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "CollectionPage",
                "name" => "Каталог — Сатори Ко",
                "description" => "Всички книги от издателство Сатори Ко, подредени по жанрове, автори и формати.",
                "url" => url()->current(),
            ],
        ];
    }

    public function updatedFilters(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $q = Book::query()
            ->with(['author:id,name,slug', 'genres:id,name,slug'])
            ->select(['id', 'title', 'slug', 'price', 'cover', 'format', 'author_id', 'price_eur']);

        if (!empty($this->filters['author'])) {
            $q->where('author_id', (int) $this->filters['author']);
        }

        if (!empty($this->filters['genre'])) {
            $q->whereHas('genres', function ($g) {
                $g->where('genres.id', (int) $this->filters['genre']);
            });
        }

        if (!empty($this->filters['format'])) {
            $q->where('format', $this->filters['format']);
        }

        switch ($this->sort) {
            case 'new':
                $q->latest();
                break;
            case 'price_asc':
                $q->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $q->orderBy('price', 'desc');
                break;
            case 'popular':
            default:
                $q->latest();
                break;
        }

        $booksPaginator = $q->paginate(12)->withQueryString();

        $books = $booksPaginator->through(function (Book $b) {
            $cover = $b->cover
                ? (Str::startsWith($b->cover, ['http://', 'https://'])
                    ? $b->cover
                    : asset('storage/' . ltrim($b->cover, '/')))
                : asset('storage/images/default-book.jpg');

            return [
                'id'        => $b->id,
                'title'     => $b->title,
                'price'     => (float) $b->price,
                'price_eur' => (float) $b->price_eur,
                'slug'      => $b->slug,
                'cover'     => $cover,
            ];
        });

        return view('livewire.pages.catalog', [
            'books'          => $books,
            'booksPaginator' => $booksPaginator,
            'authorOptions'  => $this->authorOptions,
            'genreOptions'   => $this->genreOptions,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
