<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Livewire\Concerns\UsesCart;

class AddButton extends Component
{
    use UsesCart;

    public int $bookId;
    public string $bookTitle;
    public float $price;

    public function render()
    {
        return view('livewire.cart.add-button');
    }
}
