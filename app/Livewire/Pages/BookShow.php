<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class BookShow extends Component
{
    public string $slug;
    public array $book = [];

    public function mount(string $slug)
    {
        $this->slug = $slug;

        // TODO: замени с реален Book::whereSlug($slug)->with('author','reviews.user')->firstOrFail()
        $this->book = [
            'id' => 1,
            'slug' => $slug,
            'title' => 'Присъствие – Специално издание',
            'author' => ['name' => 'Екхарт Толе', 'slug' => 'eckhart-tolle'],
            'price' => 26.90,
            'format' => 'paper', // 'paper' | 'ebook'
            'cover' => asset('storage/images/hero-1.jpg'),
            'description' => str_repeat('Дълбоко, практично ръководство за осъзнатост и вътрешен мир. ', 40),
            'excerpt_url' => asset('storage/excerpts/presence.pdf'),
            'rating_avg' => 4.6,
            'rating_count' => 37,
            'reviews' => [
                ['user' => 'Мария', 'rating' => 5, 'content' => 'Страхотна книга, много ми помогна!'],
                ['user' => 'Иван', 'rating' => 4, 'content' => 'Много добра, бих препоръчал.'],
            ],
        ];
    }

    public function addToCart(int $qty = 1): void
    {
        $cart = session()->get('cart', ['count' => 0, 'items' => []]);

        $cart['count'] += max(1, $qty);
        $cart['items'][] = [
            'id' => $this->book['id'],
            'title' => $this->book['title'],
            'price' => $this->book['price'],
            'qty' => max(1, $qty),
        ];

        session(['cart' => $cart, 'cart.count' => $cart['count']]);

        $this->dispatch('cart:updated');
        $this->dispatch('notify', message: 'Книгата е добавена в количката.');
    }

    public function render()
    {
        return view('livewire.pages.book-show', [
            'book' => $this->book,
        ])->layout('layouts.app', [
            'title' => $this->book['title'] . ' — Сатори Ко',
        ]);
    }
}
