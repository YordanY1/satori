<?php

namespace App\Livewire\Pages;

use App\Livewire\Concerns\UsesCart;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use UsesCart, WithPagination;

    public array $filters = [
        'author' => null,
        'genre' => null,
        'format' => null,
        'price' => null,
    ];

    public string $sort = 'popular';

    public $authorOptions = [];

    public $genreOptions = [];

    public array $seo = [];

    protected $queryString = [
        'sort' => ['except' => 'popular'],
        'page' => ['except' => 1],
    ];

    public function mount(): void
    {
        $this->authorOptions = Author::orderBy('name')->get(['id', 'name', 'slug']);
        $this->genreOptions = Genre::orderBy('name')->get(['id', 'name', 'slug']);

        $author = request('author');
        $genre = request('genre');
        $format = request('format');

        if ($author && ($m = Author::where('slug', $author)->first())) {
            $this->filters['author'] = $m->id;
        }

        if ($genre && ($g = Genre::where('slug', $genre)->first())) {
            $this->filters['genre'] = $g->id;
        }

        if ($format) {
            $this->filters['format'] = $format;
        }

        $this->seo = [
            'title' => 'Каталог — Издателство Сатори',
            'description' => 'Разгледай каталога на Издателство Сатори – книги по жанрове, автори и формати.',
            'keywords' => 'сатори, книги, каталог, автори, жанрове, литература',
            'canonical' => url()->current(),
            'og:title' => 'Каталог — Издателство Сатори',
            'og:description' => 'Пълен каталог с книги от Издателство Сатори.',
            'og:type' => 'website',
            'og:image' => asset('images/og/catalog.jpg'),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Каталог — Издателство Сатори',
            'twitter:description' => 'Всички книги по жанрове, автори и формати от Издателство Сатори.',
            'twitter:image' => asset('images/og/catalog.jpg'),
        ];

        if (isset($m)) {
            $this->seo['title'] = "Книги от {$m->name} — Издателство Сатори";
            $this->seo['description'] = "Открий книги от {$m->name}.";
        }

        if (isset($g)) {
            $this->seo['title'] = "Книги в жанр {$g->name} — Издателство Сатори";
            $this->seo['description'] = "Разгледай книги в категория {$g->name}.";
        }

        if ($format) {
            $formatName = $format === 'paper' ? 'Хартиено издание' : 'Е-книга';
            $this->seo['title'] = "{$formatName} — Издателство Сатори";
            $this->seo['description'] = "Разгледай книги във формат {$formatName}.";
        }

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
                'itemListElement' => [],
            ],
        ];
    }

    public function updatedFilters()
    {
        $this->resetPage();

        $authorSlug = optional(Author::find($this->filters['author']))->slug;
        $genreSlug = optional(Genre::find($this->filters['genre']))->slug;

        $query = array_filter([
            'author' => $authorSlug,
            'genre' => $genreSlug,
            'format' => $this->filters['format'],
        ], fn ($v) => filled($v));

        return redirect()->route('catalog', $query);
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

        if (! empty($this->filters['author'])) {
            $q->where('author_id', (int) $this->filters['author']);
        }

        if (! empty($this->filters['genre'])) {
            $q->whereHas('genres', fn ($g) => $g->where('genres.id', (int) $this->filters['genre']));
        }

        if (! empty($this->filters['format'])) {
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
            default:
                $q->latest();
                break;
        }

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

        // Dynamic ItemList schema
        $this->seo['schema']['mainEntity']['itemListElement'] = $books->map(function ($b, $i) {
            return [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'url' => route('book.show', $b['slug']),
                'name' => $b['title'],
            ];
        })->values()->toArray();

        return view('livewire.pages.catalog', [
            'books' => $books,
            'booksPaginator' => $booksPaginator,
            'authorOptions' => $this->authorOptions,
            'genreOptions' => $this->genreOptions,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
