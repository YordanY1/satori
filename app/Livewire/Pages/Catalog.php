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
        'filters',
        'sort' => ['except' => 'popular'],
        'page' => ['except' => 1],
    ];

    public function mount(?string $author = null, ?string $genre = null, ?string $format = null): void
    {
        $this->authorOptions = Author::orderBy('name')->get(['id', 'name', 'slug']);
        $this->genreOptions = Genre::orderBy('name')->get(['id', 'name', 'slug']);

        // Default SEO
        $this->seo = [
            'title' => 'Каталог — Издателство Сатори',
            'description' => 'Разгледай каталога на Издателство Сатори – книги по жанрове, автори и формати. Литература, духовност, философия и вдъхновение за осъзнат живот.',
            'keywords' => 'издателство сатори, книги, каталог, автори, жанрове, духовност, философия, литература',
            'canonical' => url()->current(),
            'og:title' => 'Каталог — Издателство Сатори',
            'og:description' => 'Пълен каталог на книги по жанрове и автори от Издателство Сатори.',
            'og:type' => 'website',
            'og:image' => asset('images/logo.png'),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Каталог — Издателство Сатори',
            'twitter:description' => 'Всички книги по жанрове, автори и формати от Издателство Сатори.',
            'twitter:image' => asset('images/og/catalog.jpg'),
        ];

        // Dynamic SEO by filter
        if ($author) {
            $authorModel = Author::where('slug', $author)->first();
            if ($authorModel) {
                $this->seo['title'] = "Книги от {$authorModel->name} — Издателство Сатори";
                $this->seo['description'] = "Открий книги от {$authorModel->name} в каталога на Издателство Сатори — вдъхновение, философия и духовност.";
            }
        }

        if ($genre) {
            $genreModel = Genre::where('slug', $genre)->first();
            if ($genreModel) {
                $this->seo['title'] = "Книги в жанр {$genreModel->name} — Издателство Сатори";
                $this->seo['description'] = "Разгледай книги в категория {$genreModel->name} от Издателство Сатори — литература, вдъхновение и осъзнат живот.";
            }
        }

        if ($format) {
            $this->filters['format'] = $format;
        }

        // Base schema
        $this->seo['schema'] = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Каталог — Издателство Сатори',
            'description' => 'Всички книги от Издателство Сатори, подредени по жанрове, автори и формати.',
            'url' => url()->current(),
            'publisher' => [
                '@type' => 'Organization',
                '@id' => url('#organization'),
                'name' => 'Издателство Сатори',
                'alternateName' => 'Сатори Ко',
                'url' => url('/'),
                'logo' => asset('images/logo.png'),
                'sameAs' => [
                    'https://www.facebook.com/VBelenski',
                ],
                'contactPoint' => [
                    [
                        '@type' => 'ContactPoint',
                        'contactType' => 'Customer Support',
                        'telephone' => '+359 87 849 0782',
                        'email' => 'izdatelstvosatori@gmail.com',
                        'areaServed' => 'BG',
                        'availableLanguage' => ['Bulgarian', 'English'],
                    ],
                ],
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'ж.к. Овча Купел 1, бл. 411, магазин 2',
                    'addressLocality' => 'София',
                    'postalCode' => '1632',
                    'addressCountry' => 'BG',
                ],
            ],
            'mainEntity' => [
                '@type' => 'ItemList',
                'name' => 'Каталог на книги от Издателство Сатори',
                'itemListElement' => [],
            ],
        ];
    }

    public function updatedFilters($value, $key): void
    {
        $this->resetPage();

        $authorSlug = optional(Author::find($this->filters['author']))->slug;
        $genreSlug = optional(Genre::find($this->filters['genre']))->slug;
        $format = $this->filters['format'];

        $this->redirectRoute('catalog', [
            'author' => $authorSlug,
            'genre' => $genreSlug,
            'format' => $format,
        ]);
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
