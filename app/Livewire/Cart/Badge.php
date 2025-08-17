<?php

namespace App\Livewire\Cart;

use Livewire\Component;

class Badge extends Component
{
    public int $count = 0;

    public function mount()
    {
        $this->count = session('cart.count', 0);
    }

    protected $listeners = ['cart:updated' => 'refreshCount'];
    public function refreshCount()
    {
        $this->count = session('cart.count', 0);
    }

    public function render()
    {
        return view('livewire.cart.badge');
    }
}
