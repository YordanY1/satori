<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Livewire\Concerns\UsesCart;

class GenreShow extends Component
{
    use UsesCart;

    public string $slug;
    public array $genre = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $this->genre = [
            'name'  => ucfirst($slug),
            'desc'  => "Описание на жанра — какво включва и защо е интересен.",
            'books' => [
                [
                    'id'    => 1,
                    'slug'  => 'prisustvie-specialno-izdanie',
                    'title' => 'Присъствие – Специално издание',
                    'price' => 26.90,
                    'cover' => asset('storage/images/hero-1.jpg'),
                ],
                [
                    'id'    => 2,
                    'slug'  => 'sila-na-nastoqshtiq-moment',
                    'title' => 'Силата на настоящия момент',
                    'price' => 22.90,
                    'cover' => asset('storage/images/hero-1.jpg'),
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.genre-show', [
            'genre' => $this->genre,
        ])->layout('layouts.app', [
            'title' => $this->genre['name'] . ' — Жанр — Сатори Ко',
        ]);
    }
}
