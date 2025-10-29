<?php

namespace App\Livewire\Pages;

use App\Models\Author;
use Livewire\Component;

class Authors extends Component
{
    public $authors;

    public array $seo = [];

    public function mount(): void
    {
        $this->authors = Author::orderBy('name')
            ->get(['id', 'name', 'slug', 'photo']);

        $this->seo = [
            'title' => 'Автори — Издателство Сатори',
            'description' => 'Разгледай всички автори от Издателство Сатори – техните биографии, книги и вдъхновяващи истории.',
            'keywords' => 'издателство сатори, автори, писатели, книги, литература, български автори, международни автори',
            'canonical' => url()->current(),
            'og:title' => 'Автори — Издателство Сатори',
            'og:description' => 'Всички автори и писатели, публикувани от Издателство Сатори. Биографии, книги и снимки.',
            'og:image' => asset('images/logo.png'),
            'og:url' => url()->current(),
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Автори — Издателство Сатори',
            'twitter:description' => 'Открий биографии и произведения на авторите от Издателство Сатори.',
            'twitter:image' => asset('images/logo.png'),

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Автори — Издателство Сатори',
                'description' => 'Страница с всички автори, публикувани от Издателство Сатори.',
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
                'about' => [
                    '@type' => 'Thing',
                    'name' => 'Автори и писатели от Издателство Сатори',
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.authors', [
            'authors' => $this->authors,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
