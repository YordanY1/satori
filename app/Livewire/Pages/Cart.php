<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Support\Cart as CartStore;

class Cart extends Component
{
    public array $cart = [];
    public float $total = 0.0;

    public function mount(): void
    {
        $this->sync();
    }

    public function sync(): void
    {
        $this->cart  = CartStore::all();
        $this->total = CartStore::total();
        $this->dispatch('cart:updated', count: CartStore::count())->to('cart.badge');
    }

    public function increment(int $bookId): void
    {
        CartStore::increment($bookId);
        $this->sync();
    }

    public function decrement(int $bookId): void
    {
        CartStore::decrement($bookId);
        $this->sync();
    }

    public function remove(int $bookId): void
    {
        CartStore::remove($bookId);
        $this->sync();
    }

    public function clear(): void
    {
        CartStore::clear();
        $this->sync();
    }

    public function render()
    {
        return view('livewire.pages.cart')->layout('layouts.app');
    }
}
