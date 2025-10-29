<?php

namespace App\Livewire\Pages;

use App\Models\Genre;
use Livewire\Component;

class Genres extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Жанрове и Теми — Издателство Сатори',
            'description' => 'Разгледай жанровете и темите в каталога на Издателство Сатори — литература, философия, духовност, психология, поезия и още.',
            'keywords' => 'издателство сатори, жанрове, книги, теми, литература, философия, духовност, поезия',
            'canonical' => url()->current(),
            'og:title' => 'Жанрове и Теми — Издателство Сатори',
            'og:description' => 'Категории и жанрове книги от Издателство Сатори – философия, духовност, литература, психология и още.',
            'og:image' => asset('images/logo.png'),
            'og:url' => url()->current(),
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Жанрове и Теми — Издателство Сатори',
            'twitter:description' => 'Разгледай категориите и жанровете в каталога на Издателство Сатори.',
            'twitter:image' => asset('images/default-og.jpg'),

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Жанрове и Теми — Издателство Сатори',
                'description' => 'Открий книги от различни жанрове в каталога на Издателство Сатори — литература, философия, духовност, психология и още.',
                'url' => url()->current(),
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
                    'name' => 'Жанрове и Теми',
                    'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
                    'itemListElement' => Genre::orderBy('name')->get(['name', 'slug'])
                        ->map(function ($genre, $i) {
                            return [
                                '@type' => 'Thing',
                                'position' => $i + 1,
                                'name' => $genre->name,
                                'url' => route('genre.show', $genre->slug),
                            ];
                        })->toArray(),
                ],
            ],
        ];
    }

    public function render()
    {
        $genres = Genre::orderBy('name')->get(['id', 'name', 'slug']);

        return view('livewire.pages.genres', compact('genres'))
            ->layout('layouts.app', [
                'seo' => $this->seo,
            ]);
    }
}
