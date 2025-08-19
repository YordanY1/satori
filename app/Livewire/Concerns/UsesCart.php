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
            'title'       => $book->title,
            'price'       => (float) $book->price,
            'cover'       => $book->cover,
            'slug'        => $book->slug,
            'quantity'    => max(1, $qty),
            'weight'      => (float) ($book->weight ?? 0.5),
        ]);

        \Log::info('CART:after_put', [
            'book_id'  => $book->id,
            'added'    => [
                'title'    => $book->title,
                'price'    => (float) $book->price,
                'slug'     => $book->slug,
                'quantity' => max(1, $qty),
                'weight'   => (float) ($book->weight ?? 0.5),
            ],
            'cart_all' => Cart::all(),
            'count'    => Cart::count(),
            'subtotal' => Cart::total(),
        ]);


        $this->dispatch('cart:updated', count: Cart::count())->to('cart.badge');
        $this->dispatch('notify', message: __('cart.added'));

        $this->dispatch('cart-updated');
    }
}
