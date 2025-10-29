<?php

namespace App\Livewire\Pages;

use App\Livewire\Concerns\UsesCart;
use App\Models\Author;
use Illuminate\Support\Str;
use Livewire\Component;

class AuthorShow extends Component
{
    use UsesCart;

    public string $slug;

    public array $author = [];

    public array $seo = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $a = Author::query()
            ->where('slug', $slug)
            ->with([
                'books:id,title,slug,price,cover,author_id',
                'quotes' => fn ($q) => $q->published()->ordered(),
                'links' => fn ($q) => $q->published()->ordered(),
                'media' => fn ($q) => $q->published()->youtube()->ordered(),
            ])->firstOrFail();

        // Photo
        $photo = $a->photo
            ? (Str::startsWith($a->photo, ['http://', 'https://']) ? $a->photo : asset($a->photo))
            : asset('storage/authors/default.jpg');

        // Books
        $books = $a->books->map(function ($b) {
            $cover = $b->cover
                ? (Str::startsWith($b->cover, ['http://', 'https://']) ? $b->cover : asset($b->cover))
                : asset('storage/images/default-book.jpg');

            return [
                'id' => $b->id,
                'slug' => $b->slug,
                'title' => $b->title,
                'price' => (float) $b->price,
                'cover' => $cover,
            ];
        })->toArray();

        // Quotes, videos, interviews
        $quotes = $a->quotes->pluck('quote')->all();

        $videos = $a->media->map(fn ($m) => [
            'type' => 'youtube',
            'id' => $m->youtube_id,
            'title' => $m->title ?? 'Видео',
        ])->toArray();

        $interviews = $a->links->map(fn ($l) => [
            'title' => $l->title,
            'url' => $l->url,
        ])->toArray();

        // Author info
        $this->author = [
            'name' => $a->name,
            'photo' => $photo,
            'bio' => $a->bio ?? '',
            'quotes' => $quotes,
            'videos' => $videos,
            'interviews' => $interviews,
            'books' => $books,
        ];

        // SEO + Schema
        $description = Str::limit(strip_tags($a->bio ?? 'Открий книги и интервюта от '.$a->name), 160);

        $this->seo = [
            'title' => "{$a->name} — Автор — Издателство Сатори",
            'description' => $description,
            'keywords' => "{$a->name}, книги, автор, писател, Издателство Сатори",
            'canonical' => url()->current(),
            'og:title' => "{$a->name} — Автор — Издателство Сатори",
            'og:description' => $description,
            'og:image' => $photo,
            'og:url' => url()->current(),
            'og:type' => 'profile',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => "{$a->name} — Автор — Издателство Сатори",
            'twitter:description' => $description,
            'twitter:image' => $photo,

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => $a->name,
                'image' => $photo,
                'description' => Str::limit(strip_tags($a->bio ?? ''), 200),
                'url' => url()->current(),
                'worksFor' => [
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
                            'email' => 'satorico@izdatelstvosatori@gmail.com',
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
                'hasWritten' => collect($books)->map(fn ($b) => [
                    '@type' => 'Book',
                    'name' => $b['title'],
                    'url' => route('book.show', $b['slug']),
                ])->toArray(),
                'sameAs' => array_values(array_filter([
                    $a->website ?? null,
                    $a->facebook ?? null,
                    $a->instagram ?? null,
                    $a->youtube ?? null,
                ])),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.author-show', [
            'author' => $this->author,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
