<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Home extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Издателство Сатори — Осъзнати книги, събития и вдъхновение',
            'description' => 'Добре дошли в Издателство Сатори – домът на осъзнатите книги, духовните практики и вдъхновяващите събития. Разгледайте каталога с автори, жанрове и нови издания.',
            'keywords' => 'издателство сатори, книги, духовност, философия, литература, събития, осъзнатост, вдъхновение',
            'canonical' => url('/'),
            'og:title' => 'Издателство Сатори — Осъзнати книги и вдъхновение',
            'og:description' => 'Издателство Сатори предлага книги, събития и идеи, които вдъхновяват осъзнатостта и личностното израстване.',
            'og:url' => url('/'),
            'og:image' => asset('images/default-og.jpg'),
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Издателство Сатори | Книги, Събития, Осъзнатост',
            'twitter:description' => 'Добре дошли в Издателство Сатори – платформа за книги, събития и вдъхновение.',
            'twitter:image' => asset('images/default-og.jpg'),

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => 'Издателство Сатори',
                'alternateName' => 'Сатори Ко',
                'url' => url('/'),
                'inLanguage' => app()->getLocale(),
                'description' => 'Платформа за книги, събития и вдъхновение – Издателство Сатори.',
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
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => url('/catalog').'?q={search_term_string}',
                    'query-input' => 'required name=search_term_string',
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.home')
            ->layout('layouts.app', ['seo' => $this->seo]);
    }
}
