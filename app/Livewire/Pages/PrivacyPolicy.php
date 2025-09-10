<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class PrivacyPolicy extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Политика за поверителност — Сатори Ко',
            'description' => 'Научи как Сатори Ко събира, използва и защитава личните ти данни според GDPR. Прочети нашата политика за поверителност.',
            'keywords' => 'сатори, политика за поверителност, gdpr, лични данни, поверителност',
            'og:image' => asset('images/og/privacy.jpg'),
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "WebPage",
                "name" => "Политика за поверителност — Сатори Ко",
                "description" => "Официална политика за поверителност и защита на личните данни на Сатори Ко.",
                "url" => url()->current(),
                "mainEntity" => [
                    "@type" => "WebPageElement",
                    "name" => "Privacy Policy",
                ]
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
