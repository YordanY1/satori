<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Support\Cart;

class Badge extends Component
{
    public int $count = 0;

    protected $listeners = ['cart:updated' => 'refreshCount'];

    public function mount(): void
    {
        $this->refreshCount();
    }

    public function refreshCount(int $count = null): void
    {
        $this->count = $count ?? Cart::count();
    }

    public function render()
    {
        return view('livewire.cart.badge');
    }
}
