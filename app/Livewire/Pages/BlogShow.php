<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;

class BlogShow extends Component
{
    public Post $post;

    public array $seo = [];

    public function mount(string $slug): void
    {
        $this->post = Post::where('slug', $slug)->firstOrFail();

        $cover = $this->post->cover
            ? (Str::startsWith($this->post->cover, ['http://', 'https://'])
                ? $this->post->cover
                : asset($this->post->cover))
            : asset('storage/images/hero-1.jpg');

        $excerpt = $this->post->excerpt
            ?: Str::limit(strip_tags($this->post->content ?? ''), 160);

        $authorName = $this->post->author ?: 'Екипът на Издателство Сатори';

        $this->seo = [
            'title' => "{$this->post->title} — Блог — Издателство Сатори",
            'description' => $excerpt,
            'keywords' => "{$this->post->title}, блог, статия, книги, Издателство Сатори, култура",
            'canonical' => url()->current(),
            'og:title' => "{$this->post->title} — Издателство Сатори",
            'og:description' => $excerpt,
            'og:url' => url()->current(),
            'og:type' => 'article',
            'og:image' => $cover,
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $this->post->title,
            'twitter:description' => $excerpt,
            'twitter:image' => $cover,

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $this->post->title,
                'description' => $excerpt,
                'image' => [$cover],
                'author' => [
                    '@type' => 'Person',
                    'name' => $authorName,
                ],
                'datePublished' => optional($this->post->created_at)->toIso8601String(),
                'dateModified' => optional($this->post->updated_at)->toIso8601String(),
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => url()->current(),
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
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.blog-show', [
            'post' => $this->post,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
