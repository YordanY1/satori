<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Terms extends Component
{
    public function render()
    {
        return view('livewire.pages.terms')
            ->title('Общи условия');
    }
}
