<?php

namespace App\Livewire\Pages;

use App\Livewire\Concerns\UsesCart;
use App\Models\Book;
use Illuminate\Support\Str;
use Livewire\Component;

class BookShow extends Component
{
    use UsesCart;

    public string $slug;

    public array $book = [];

    public array $seo = [];

    protected $listeners = ['review:created' => 'reloadReviews'];

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $b = Book::query()
            ->where('slug', $slug)
            ->with([
                'author:id,name,slug',
                'reviews' => fn ($q) => $q->latest(),
            ])
            ->firstOrFail();

        // Cover & excerpt
        $cover = $b->cover
            ? (Str::startsWith($b->cover, ['http://', 'https://'])
                ? $b->cover
                : asset('storage/'.ltrim($b->cover, '/')))
            : asset('storage/images/default-book.jpg');

        $excerptUrl = $b->excerpt
            ? (Str::startsWith($b->excerpt, ['http://', 'https://'])
                ? $b->excerpt
                : asset('storage/'.ltrim($b->excerpt, '/')))
            : null;

        // Reviews
        $reviews = $b->reviews->map(fn ($r) => [
            'user' => $r->user_name ?: 'Анонимен',
            'rating' => (int) $r->rating,
            'content' => (string) ($r->content ?? ''),
        ])->toArray();

        $ratingAvg = (float) number_format($b->reviews()->avg('rating') ?? 0, 1);
        $ratingCnt = (int) $b->reviews()->count();

        // Book info
        $this->book = [
            'id' => $b->id,
            'slug' => $b->slug,
            'title' => $b->title,
            'author' => [
                'name' => $b->author->name,
                'slug' => $b->author->slug,
            ],
            'price' => (float) $b->price,
            'price_eur' => (float) $b->price_eur,
            'format' => (string) $b->format,
            'cover' => $cover,
            'description' => (string) ($b->description ?? ''),
            'excerpt_url' => $excerptUrl,
            'rating_avg' => $ratingAvg,
            'rating_count' => $ratingCnt,
            'reviews' => $reviews,
        ];

        // SEO description
        $desc = Str::limit(strip_tags($this->book['description']), 160)
            ?: 'Книга от '.$this->book['author']['name'];

        // SEO meta
        $this->seo = [
            'title' => "{$this->book['title']} — Книга — Издателство Сатори",
            'description' => $desc,
            'keywords' => "{$this->book['title']}, {$this->book['author']['name']}, книга, Издателство Сатори, литература, духовност",
            'canonical' => url()->current(),
            'og:title' => "{$this->book['title']} — Издателство Сатори",
            'og:description' => $desc,
            'og:image' => $cover,
            'og:url' => url()->current(),
            'og:type' => 'book',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $this->book['title'],
            'twitter:description' => $desc,
            'twitter:image' => $cover,

            // Schema.org
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Book',
                'name' => $this->book['title'],
                'alternateName' => $b->original_title ?? null,
                'image' => $cover,
                'description' => $desc,
                'isbn' => $b->isbn ?? null,
                'bookFormat' => $b->format ? "https://schema.org/{$b->format}" : null,
                'author' => [
                    '@type' => 'Person',
                    'name' => $this->book['author']['name'],
                    'url' => route('author.show', $this->book['author']['slug']),
                ],
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
                            'email' => 'satorico@abv.bg',
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
                'offers' => [
                    '@type' => 'Offer',
                    'price' => $this->book['price'],
                    'priceCurrency' => 'BGN',
                    'availability' => $b->stock > 0
                        ? 'https://schema.org/InStock'
                        : 'https://schema.org/OutOfStock',
                    'url' => url()->current(),
                ],
                'aggregateRating' => [
                    '@type' => 'AggregateRating',
                    'ratingValue' => $ratingAvg,
                    'reviewCount' => $ratingCnt,
                ],
            ],
        ];
    }

    public function reloadReviews(): void
    {
        $b = Book::with(['reviews' => fn ($q) => $q->latest()])
            ->findOrFail($this->book['id']);

        $reviews = $b->reviews->map(fn ($r) => [
            'user' => $r->user_name ?: 'Анонимен',
            'rating' => (int) $r->rating,
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
            'seo' => $this->seo,
        ]);
    }
}
