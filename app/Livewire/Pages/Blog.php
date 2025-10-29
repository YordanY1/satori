<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Blog extends Component
{
    use WithPagination;

    public string $q = '';

    public string $sort = 'new';

    public array $seo = [];

    protected $queryString = [
        'q' => ['except' => ''],
        'sort' => ['except' => 'new'],
        'page' => ['except' => 1],
    ];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Блог — Издателство Сатори',
            'description' => 'Чети последните статии, новини и вдъхновения от екипа на Издателство Сатори – литература, култура, осъзнатост и духовност.',
            'keywords' => 'издателство сатори, блог, статии, книги, култура, литература, духовност',
            'canonical' => url()->current(),
            'og:title' => 'Блог — Издателство Сатори',
            'og:description' => 'Най-новите статии, вдъхновения и културни анализи от Издателство Сатори.',
            'og:image' => asset('images/logo.png'),
            'og:url' => url()->current(),
            'og:type' => 'blog',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Блог — Издателство Сатори',
            'twitter:description' => 'Вдъхновения, статии и новини от Издателство Сатори.',
            'twitter:image' => asset('images/og/blog.jpg'),

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Blog',
                'name' => 'Блог — Издателство Сатори',
                'headline' => 'Блог — Издателство Сатори',
                'description' => 'Официалният блог на Издателство Сатори – място за вдъхновение, духовност и литературна култура.',
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
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'name' => 'Статии в блога на Издателство Сатори',
                    'itemListElement' => [],
                ],
            ],
        ];
    }

    public function updatedQ(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $q = Post::query()->select([
            'id',
            'title',
            'slug',
            'author',
            'excerpt',
            'content',
            'cover',
            'created_at',
        ]);

        if ($this->q !== '') {
            $q->where(function ($qq) {
                $qq->where('title', 'like', '%'.$this->q.'%')
                    ->orWhere('excerpt', 'like', '%'.$this->q.'%')
                    ->orWhere('content', 'like', '%'.$this->q.'%');
            });
        }

        match ($this->sort) {
            'title' => $q->orderBy('title'),
            default => $q->latest('created_at'),
        };

        $paginator = $q->paginate(12)->withQueryString();

        $posts = $paginator->through(function (Post $p) {
            $cover = $p->cover
                ? (Str::startsWith($p->cover, ['http://', 'https://']) ? $p->cover : asset($p->cover))
                : asset('storage/images/hero-1.jpg');

            return [
                'title' => $p->title,
                'slug' => $p->slug,
                'excerpt' => $p->excerpt ?: Str::limit(strip_tags($p->content ?? ''), 180),
                'cover' => $cover,
                'author' => $p->author ?? 'Неизвестен автор',
                'date' => optional($p->created_at)->toDateString(),
            ];
        });

        $this->seo['schema']['mainEntity']['itemListElement'] = $posts->map(function ($p, $i) {
            return [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'url' => route('blog.show', $p['slug']),
                'name' => $p['title'],
            ];
        })->values()->toArray();

        return view('livewire.pages.blog', [
            'posts' => $posts,
            'paginator' => $paginator,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
