<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Order;

class ThankYou extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.pages.thank-you', [
            'order' => $this->order,
        ])->layout('layouts.app', [
            'title' => 'Благодарим за поръчката!',
        ]);
    }
}
