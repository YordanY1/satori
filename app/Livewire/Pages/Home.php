<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Home extends Component
{
    public array $seo = [];

    public function mount()
    {
        $this->seo = [
            'title' => 'Сатори Ко | Начало',
            'description' => 'Добре дошли в Сатори – платформа за книги, събития и вдъхновение.',
            'keywords' => 'сатори, книги, събития, осъзнатост, духовност',
            'og:image' => asset('images/default-og.jpg'),
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "WebSite",
                "name" => "Сатори Ко",
                "url" => url('/'),
            ]
        ];
    }

    public function render()
    {
        return view('livewire.pages.home')
            ->layout('layouts.app', ['seo' => $this->seo]);
    }
}
