<?php

namespace App\Livewire\Cart;

use Livewire\Component;

class AddButton extends Component
{
    public $bookId;
    public $bookTitle;
    public $price;
    public $qty = 1;

    public function addToCart()
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$this->bookId])) {
            $cart[$this->bookId] = [
                'title' => $this->bookTitle,
                'price' => $this->price,
                'qty'   => 0,
            ];
        }

        $cart[$this->bookId]['qty'] += max(1, (int) $this->qty);

        session()->put('cart', $cart);


        $this->dispatch('cart-updated');

        $this->dispatch('notify', message: 'Книгата е добавена в количката.');
    }

    public function render()
    {
        return view('livewire.cart.add-button');
    }
}
