<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class Orders extends Component
{
    public function render(): View
    {
        $orders = Auth::user()
            ->orders()
            ->with('items')
            ->latest()
            ->get();

        return view('livewire.profile.orders', [
            'orders' => $orders,
        ])->layout('layouts.app');
    }
}
