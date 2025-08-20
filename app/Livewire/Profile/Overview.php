<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class Overview extends Component
{
    public function render(): View
    {
        return view('livewire.profile.overview', [
            'user' => Auth::user(),
        ])->layout('layouts.app');
    }
}
