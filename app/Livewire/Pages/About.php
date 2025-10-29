<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class About extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'За нас – Издателство Сатори',
            'description' => 'Научи повече за мисията, историята и екипа зад Издателство Сатори – домът на осъзнатите книги и културни събития.',
            'keywords' => 'издателство сатори, за нас, книги, екип, мисия, духовност, литература',
            'og:image' => asset('images/logo.png'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'AboutPage',
                'name' => 'За нас – Издателство Сатори',
                'description' => 'Мисията, историята и екипът зад Издателство Сатори – вдъхновение чрез книги, събития и култура.',
                'publisher' => [
                    '@type' => 'Organization',
                    '@id' => url('#organization'),
                    'name' => 'Издателство Сатори',
                    'alternateName' => 'Сатори Ко',
                    'logo' => asset('images/logo.png'),
                    'url' => url('/'),
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
                'url' => url()->current(),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.about')
            ->layout('layouts.app', [
                'seo' => $this->seo,
            ]);
    }
}
