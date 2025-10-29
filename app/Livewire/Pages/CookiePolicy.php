<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class CookiePolicy extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Политика за бисквитки — Издателство Сатори',
            'description' => 'Политиката за бисквитки на Издателство Сатори описва как използваме cookies за подобряване на потребителското изживяване и защита на личните данни.',
            'keywords' => 'издателство сатори, бисквитки, cookie policy, gdpr, поверителност, лични данни',
            'canonical' => url()->current(),
            'og:title' => 'Политика за бисквитки — Издателство Сатори',
            'og:description' => 'Научи как Издателство Сатори използва бисквитки, за да подобри твоето преживяване на сайта и да защити личните ти данни.',
            'og:image' => asset('images/logo.png'),
            'og:url' => url()->current(),
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Политика за бисквитки — Издателство Сатори',
            'twitter:description' => 'Политиката на Издателство Сатори за използване на бисквитки и защита на личните данни.',
            'twitter:image' => asset('images/og/policy.jpg'),

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'LegalWebPage',
                'name' => 'Политика за бисквитки — Издателство Сатори',
                'description' => 'Официална политика за използване на бисквитки на Издателство Сатори.',
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
                    '@type' => 'WebPageElement',
                    'name' => 'Cookie Policy',
                    'inLanguage' => app()->getLocale(),
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.cookie-policy')
            ->layout('layouts.app', [
                'seo' => $this->seo,
            ]);
    }
}
