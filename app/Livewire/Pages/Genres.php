<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Genre;

class Genres extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Жанрове и Теми — Сатори Ко',
            'description' => 'Разгледай жанровете и темите в платформата Сатори Ко — литература, философия, духовност и още.',
            'keywords' => 'сатори, жанрове, книги, теми, литература, философия, духовност',
            'og:image' => asset('images/default-og.jpg'),
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "CollectionPage",
                "name" => "Жанрове и Теми — Сатори Ко",
                "description" => "Категории и жанрове книги в платформата Сатори Ко.",
                "url" => url()->current(),
            ],
            'canonical' => url()->current(),
            'og:title' => 'Жанрове и Теми — Сатори Ко',
            'og:description' => 'Разгледай жанровете и темите в платформата Сатори Ко — литература, философия, духовност и още.',
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Жанрове и Теми — Сатори Ко',
            'twitter:description' => 'Разгледай жанровете и темите в платформата Сатори Ко — литература, философия, духовност и още.',
            'twitter:image' => asset('images/default-og.jpg'),

        ];
    }

    public function render()
    {
        $genres = Genre::orderBy('name')->get(['id', 'name', 'slug']);

        return view('livewire.pages.genres', compact('genres'))
            ->layout('layouts.app', [
                'seo' => $this->seo,
            ]);
    }
}
