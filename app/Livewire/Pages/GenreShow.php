<?php

namespace App\Livewire\Pages;

use App\Livewire\Concerns\UsesCart;
use App\Models\Genre;
use Illuminate\Support\Str;
use Livewire\Component;

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
            ->with([
                'books' => fn ($q) => $q->with('author:id,name,slug')
                    ->latest('id')
                    ->take(24),
            ])
            ->firstOrFail();

        $books = $genre->books->map(fn ($b) => [
            'id' => $b->id,
            'slug' => $b->slug,
            'title' => $b->title,
            'price' => (float) $b->price,
            'price_eur' => (float) $b->price_eur,
            'cover' => $b->cover
                ? (str_starts_with($b->cover, 'http')
                    ? $b->cover
                    : asset('storage/'.ltrim($b->cover, '/')))
                : asset('storage/images/default-book.jpg'),
            'author' => $b->author?->name,
            'author_slug' => $b->author?->slug,
        ])->all();

        $desc = Str::limit(strip_tags($genre->description ?? 'Книги от жанра '.$genre->name), 160);

        $this->genre = [
            'name' => $genre->name,
            'desc' => $genre->description ?? '',
            'books' => $books,
        ];

        $this->seo = [
            'title' => $genre->name.' — Жанр — Издателство Сатори',
            'description' => $desc,
            'keywords' => $genre->name.', книги, жанр, издателство сатори, литература, философия, духовност',
            'canonical' => url()->current(),
            'og:title' => $genre->name.' — Жанр — Издателство Сатори',
            'og:description' => $desc,
            'og:image' => $books[0]['cover'] ?? asset('images/default-og.jpg'),
            'og:url' => url()->current(),
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $genre->name.' — Издателство Сатори',
            'twitter:description' => $desc,
            'twitter:image' => $books[0]['cover'] ?? asset('images/default-og.jpg'),

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => $genre->name.' — Жанр — Издателство Сатори',
                'description' => Str::limit(strip_tags($genre->description ?? ''), 200),
                'url' => url()->current(),
                'about' => [
                    '@type' => 'Thing',
                    'name' => $genre->name,
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    '@id' => url('#organization'),
                    'name' => 'Издателство Сатори',
                    'alternateName' => 'Сатори Ко',
                    'url' => url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('images/logo.png'),
                    ],
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
                    'name' => $genre->name.' — Каталог книги',
                    'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
                    'itemListElement' => collect($books)->map(fn ($b, $i) => [
                        '@type' => 'Book',
                        'position' => $i + 1,
                        'name' => $b['title'],
                        'url' => route('book.show', $b['slug']),
                        'image' => $b['cover'],
                        'author' => [
                            '@type' => 'Person',
                            'name' => $b['author'],
                            'url' => $b['author_slug']
                                ? route('author.show', $b['author_slug'])
                                : null,
                        ],
                        'offers' => [
                            '@type' => 'Offer',
                            'price' => $b['price'],
                            'priceCurrency' => 'BGN',
                            'availability' => 'https://schema.org/InStock',
                            'url' => route('book.show', $b['slug']),
                        ],
                    ])->toArray(),
                ],
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
