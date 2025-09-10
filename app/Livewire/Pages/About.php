<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class About extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'За нас – Сатори Ко',
            'description' => 'Научи повече за мисията, историята и екипа зад издателство Сатори Ко. Вдъхновение чрез книги, събития и култура.',
            'keywords' => 'сатори, за нас, история, екип, издателство, книги',
            'og:image' => asset('images/og/about.jpg'),
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "AboutPage",
                "name" => "За нас – Сатори Ко",
                "description" => "Мисията, историята и екипът зад издателство Сатори Ко.",
                "publisher" => [
                    "@type" => "Organization",
                    "name" => "Сатори Ко",
                    "logo" => asset('images/logo.png'),
                    "url" => url('/'),
                    "sameAs" => [
                        "https://www.facebook.com/...",
                        "https://www.instagram.com/...",
                        "https://www.linkedin.com/..."
                    ]
                ],
                "url" => url()->current(),
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
