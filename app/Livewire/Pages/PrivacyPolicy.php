<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class PrivacyPolicy extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Политика за поверителност — Издателство Сатори',
            'description' => 'Научи как Издателство Сатори събира, използва и защитава личните ти данни в съответствие с GDPR. Прочети официалната политика за поверителност.',
            'keywords' => 'издателство сатори, политика за поверителност, лични данни, gdpr, privacy policy',
            'canonical' => url()->current(),
            'og:title' => 'Политика за поверителност — Издателство Сатори',
            'og:description' => 'Официална GDPR политика за защита на личните данни от Издателство Сатори.',
            'og:image' => asset('images/og/privacy.jpg'),
            'og:url' => url()->current(),
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Политика за поверителност — Издателство Сатори',
            'twitter:description' => 'Прочети как Издателство Сатори обработва и защитава личните данни според GDPR.',
            'twitter:image' => asset('images/og/privacy.jpg'),

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'LegalWebPage',
                'name' => 'Политика за поверителност — Издателство Сатори',
                'description' => 'Документ, описващ как Издателство Сатори събира, съхранява и защитава лични данни в съответствие с Общия регламент за защита на данните (GDPR).',
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
                'mainEntity' => [
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'Какви лични данни събира Издателство Сатори?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Издателство Сатори събира само необходимите данни за обработка на поръчки, комуникация и маркетинг с изрично съгласие от потребителя.',
                            ],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Как се съхраняват личните данни?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Данните се съхраняват сигурно в съответствие с GDPR, като достъпът до тях е ограничен и защитен с криптиране и контрол на достъпа.',
                            ],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Как мога да поискам изтриване на личните си данни?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Всеки потребител може да поиска изтриване на своите данни, като се свърже с нас на имейл satorico@abv.bg.',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.privacy-policy')
            ->layout('layouts.app', [
                'seo' => $this->seo,
            ]);
    }
}
