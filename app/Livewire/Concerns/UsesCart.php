<?php

namespace App\Livewire\Concerns;

use App\Models\Book;
use App\Support\Cart;

trait UsesCart
{
    public function addToCart(int $bookId, int $qty = 1): void
    {
        $book = Book::findOrFail($bookId);

        Cart::put($book->id, [
            'title'    => $book->title,
            'price'    => (float) $book->price,
            'cover'    => $book->cover,
            'slug'     => $book->slug,
            'quantity' => $qty,
        ]);

        $this->dispatch('cart:updated', count: Cart::count())->to('cart.badge');
        $this->dispatch('notify', message: 'Добавено в количката 🛒');
        $this->dispatch('cart-updated');
    }
}
