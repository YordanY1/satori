<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Author;

class Authors extends Component
{
    public $authors;
    public array $seo = [];

    public function mount(): void
    {
        $this->authors = Author::orderBy('name')
            ->get(['id', 'name', 'slug', 'photo']);

        $this->seo = [
            'title' => 'Автори — Сатори Ко',
            'description' => 'Разгледай всички автори в платформата Сатори Ко. Биографии, книги и снимки на любими писатели.',
            'keywords' => 'сатори, автори, писатели, книги, български автори, международни автори',
            'og:image' => asset('images/default-og.jpg'),
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "CollectionPage",
                "name" => "Автори — Сатори Ко",
                "description" => "Страница с всички автори в платформата Сатори Ко.",
                "url" => url()->current(),
            ],
            'canonical' => url()->current(),
            'og:title' => 'Автори — Сатори Ко',
            'og:description' => 'Разгледай всички автори и писатели в платформата Сатори Ко – книги, биографии и снимки.',
            'og:url' => url()->current(),
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Автори — Сатори Ко',
            'twitter:description' => 'Биографии, книги и профили на всички автори в Сатори Ко.',
            'twitter:image' => asset('images/default-og.jpg'),
            "about" => [
                "@type" => "Thing",
                "name" => "Автори и писатели от Сатори Ко"
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.authors', [
            'authors' => $this->authors,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
