<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class CookiePolicy extends Component
{
    public function render()
    {
        return view('livewire.pages.cookie-policy')
            ->layout('layouts.app', [
                'title' => 'Политика за бисквитки — Сатори Ко',
            ]);
    }
}
