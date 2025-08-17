<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class GenreShow extends Component
{
    public string $slug;
    public array $genre = [];

    public function mount(string $slug)
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

    public function addToCart(int $bookId): void
    {
        $cart = session()->get('cart', ['count' => 0, 'items' => []]);
        $cart['count'] += 1;
        $cart['items'][] = ['id' => $bookId, 'qty' => 1];
        session(['cart' => $cart, 'cart.count' => $cart['count']]);
        $this->dispatch('cart:updated');
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
