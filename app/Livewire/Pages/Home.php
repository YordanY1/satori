<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Home extends Component
{
    public array $seo = [];

    public function mount(): void
    {
        $this->seo = [
            'title'       => 'Сатори Ко — Осъзнати книги, събития и вдъхновение',
            'description' => 'Добре дошли в Сатори – платформата, която съчетава литература, духовност и осъзнат живот. Разгледай книги, събития и вдъхновяващи истории.',
            'keywords'    => 'сатори, книги, събития, духовност, осъзнатост, философия, литература, самопознание',
            'canonical'   => url('/'),
            'og:title'       => 'Сатори Ко — Осъзнати книги и вдъхновение',
            'og:description' => 'Открий книги, събития и идеи, които вдъхновяват осъзнатостта.',
            'og:url'         => url('/'),
            'og:type'        => 'website',
            'twitter:title'       => 'Сатори Ко | Книги, Събития, Осъзнатост',
            'twitter:description' => 'Добре дошли в Сатори – домът на осъзнатите книги и духовните пътешествия.',
            'schema' => [
                "@context" => "https://schema.org",
                "@type"    => "WebSite",
                "name"     => "Сатори Ко",
                "url"      => url('/'),
                "inLanguage" => app()->getLocale(),
                "description" => "Платформа за книги, събития и вдъхновение – Сатори Ко.",
                "publisher" => [
                    "@type" => "Organization",
                    "name"  => "Сатори Ко",
                    "logo"  => [
                        "@type" => "ImageObject",
                        "url"   => asset('images/logo.png')
                    ]
                ],
                "potentialAction" => [
                    "@type" => "SearchAction",
                    "target" => url('/catalog') . "?q={search_term_string}",
                    "query-input" => "required name=search_term_string"
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.pages.home')
            ->layout('layouts.app', ['seo' => $this->seo]);
    }
}
