<?php

namespace App\Livewire\Pages;

use App\Livewire\Concerns\UsesCart;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use UsesCart, WithPagination;

    #[Url(as: 'authors')]
    public array $authors = [];

    #[Url(as: 'genres')]
    public array $genres = [];

    #[Url(as: 'formats')]
    public array $formats = [];

    #[Url(except: 'popular')]
    public string $sort = 'popular';

    public array $authorOptions = [];

    public array $genreOptions = [];

    public array $seo = [];

    public function mount(): void
    {
        $this->authors ??= [];
        $this->genres ??= [];
        $this->formats ??= [];

        $this->authorOptions = Author::orderBy('name')->get(['id', 'name', 'slug'])->toArray();
        $this->genreOptions = Genre::orderBy('name')->get(['id', 'name', 'slug'])->toArray();

        $this->generateSeo();
    }

    public function updated(): void
    {
        $this->resetPage();
        $this->generateSeo();
    }

    public function resetFilters(): void
    {
        $this->authors = [];
        $this->genres = [];
        $this->formats = [];
        $this->sort = 'popular';

        $this->resetPage();
        $this->generateSeo();
    }

    public function dehydrate()
    {
        $this->authors = array_values($this->authors);
        $this->genres = array_values($this->genres);
        $this->formats = array_values($this->formats);
    }

    protected function generateSeo(): void
    {
        $title = 'Каталог — Издателство Сатори';
        $description = 'Разгледай каталога на Издателство Сатори – книги по жанрове, автори и формати.';

        if (! empty($this->authors)) {
            $names = Author::whereIn('slug', $this->authors)->pluck('name')->join(', ');
            $title = "Книги от {$names} — Издателство Сатори";
            $description = "Открий книги от {$names}.";
        }

        if (! empty($this->genres)) {
            $names = Genre::whereIn('slug', $this->genres)->pluck('name')->join(', ');
            $title = "Книги в жанр {$names} — Издателство Сатори";
            $description = "Разгледай книги в категория {$names}.";
        }

        if (! empty($this->formats)) {
            $map = [
                'paper' => 'Хартиено издание',
                'ebook' => 'Е-книга',
            ];
            $names = collect($this->formats)->map(fn ($f) => $map[$f] ?? $f)->join(', ');
            $title = "{$names} — Издателство Сатори";
            $description = "Разгледай книги във формат {$names}.";
        }

        $this->seo = [
            'title' => $title,
            'description' => $description,
            'canonical' => url()->current(),
            'og:title' => $title,
            'og:description' => $description,
            'og:type' => 'website',
            'og:image' => asset('images/og/catalog.jpg'),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $title,
            'twitter:description' => $description,
            'twitter:image' => asset('images/og/catalog.jpg'),
        ];

        $this->seo['schema'] = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $this->seo['title'],
            'description' => $this->seo['description'],
            'url' => url()->current(),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Издателство Сатори',
                'url' => url('/'),
                'logo' => asset('images/logo.png'),
            ],
            'mainEntity' => [
                '@type' => 'ItemList',
                'itemListElement' => Book::latest()->take(12)->get()->map(fn ($b) => [
                    '@type' => 'ListItem',
                    'name' => $b->title,
                    'url' => route('book.show', $b->slug),
                ])->toArray(),
            ],
        ];
    }

    public function paginationView()
    {
        return 'components.pagination';
    }

    public function render()
    {
        $q = Book::query()
            ->with(['author:id,name,slug', 'genres:id,name,slug'])
            ->select(['id', 'title', 'slug', 'price', 'price_eur', 'cover', 'format', 'author_id']);

        if (! empty($this->authors)) {
            $ids = Author::whereIn('slug', $this->authors)->pluck('id');
            $q->whereIn('author_id', $ids);
        }

        if (! empty($this->genres)) {
            $ids = Genre::whereIn('slug', $this->genres)->pluck('id');
            $q->whereHas('genres', fn ($g) => $g->whereIn('genres.id', $ids));
        }

        if (! empty($this->formats)) {
            $q->whereIn('format', $this->formats);
        }

        match ($this->sort) {
            'new' => $q->latest(),
            'price_asc' => $q->orderBy('price'),
            'price_desc' => $q->orderBy('price', 'desc'),
            default => $q->latest(),
        };

        $booksPaginator = $q->paginate(12)->withQueryString();

        $books = $booksPaginator->through(function (Book $b) {
            $cover = $b->cover
                ? (Str::startsWith($b->cover, ['http://', 'https://'])
                    ? $b->cover
                    : asset('storage/'.ltrim($b->cover, '/')))
                : asset('storage/images/default-book.jpg');

            return [
                'id' => $b->id,
                'title' => $b->title,
                'price' => (float) $b->price,
                'price_eur' => (float) $b->price_eur,
                'slug' => $b->slug,
                'cover' => $cover,
            ];
        });

        return view('livewire.pages.catalog', [
            'books' => $books,
            'booksPaginator' => $booksPaginator,
            'authorOptions' => $this->authorOptions,
            'genreOptions' => $this->genreOptions,
        ])->layout('layouts.app', ['seo' => $this->seo]);
    }
}
