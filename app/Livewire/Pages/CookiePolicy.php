<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class CookiePolicy extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Политика за бисквитки — Сатори Ко',
            'description' => 'Научи как Сатори Ко използва бисквитки за подобряване на твоето потребителско изживяване и защита на личните данни.',
            'keywords' => 'сатори, бисквитки, политика, gdpr, cookies',
            'og:image' => asset('images/og/policy.jpg'),
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "WebPage",
                "name" => "Политика за бисквитки — Сатори Ко",
                "description" => "Официална политика за бисквитки на Сатори Ко.",
                "url" => url()->current(),
                "mainEntity" => [
                    "@type" => "WebPageElement",
                    "name" => "Cookie Policy",
                ]
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
