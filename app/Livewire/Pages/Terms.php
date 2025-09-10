<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Terms extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Общи условия — Сатори Ко',
            'description' => 'Прочети общите условия на Сатори Ко за ползване на уебсайта, покупки и услуги. Важно за всички потребители.',
            'keywords' => 'сатори, общи условия, terms, правила, покупки',
            'og:image' => asset('images/og/terms.jpg'),
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "WebPage",
                "name" => "Общи условия — Сатори Ко",
                "description" => "Официалните общи условия за ползване на сайта и услугите на Сатори Ко.",
                "url" => url()->current(),
                "mainEntity" => [
                    "@type" => "WebPageElement",
                    "name" => "Terms and Conditions",
                ]
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
