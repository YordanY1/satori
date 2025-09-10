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
            ]
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
