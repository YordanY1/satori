<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Terms extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Общи условия — Издателство Сатори',
            'description' => 'Прочети общите условия на Издателство Сатори за ползване на уебсайта, извършване на поръчки и защита на потребителите. Важно за всички клиенти и партньори.',
            'keywords' => 'издателство сатори, общи условия, правила, покупки, условия за ползване, terms of service',
            'canonical' => url()->current(),
            'og:title' => 'Общи условия — Издателство Сатори',
            'og:description' => 'Официалните правила за ползване на сайта и услугите на Издателство Сатори.',
            'og:image' => asset('images/og/terms.jpg'),
            'og:url' => url()->current(),
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Общи условия — Издателство Сатори',
            'twitter:description' => 'Политика, правила и условия за използване на сайта на Издателство Сатори.',
            'twitter:image' => asset('images/og/terms.jpg'),

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'TermsOfService',
                'name' => 'Общи условия — Издателство Сатори',
                'description' => 'Документ, описващ условията за ползване на уебсайта и услугите на Издателство Сатори, включително права, отговорности и защита на потребителите.',
                'url' => url()->current(),
                'inLanguage' => 'bg',
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
                'hasPart' => [
                    [
                        '@type' => 'WebPageElement',
                        'name' => 'Права и задължения на потребителите',
                        'text' => 'Потребителите са длъжни да спазват условията за ползване на сайта и да предоставят коректна информация при извършване на поръчки.',
                    ],
                    [
                        '@type' => 'WebPageElement',
                        'name' => 'Политика за рекламации и връщане на продукти',
                        'text' => 'Издателство Сатори гарантира правото на рекламация в рамките на 14 дни, съгласно българското законодателство.',
                    ],
                    [
                        '@type' => 'WebPageElement',
                        'name' => 'Авторски права и съдържание',
                        'text' => 'Цялото съдържание на уебсайта е защитено с авторски права и не може да бъде използвано без писмено съгласие от Издателство Сатори.',
                    ],
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.terms')
            ->layout('layouts.app', [
                'seo' => $this->seo,
            ]);
    }
}
