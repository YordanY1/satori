<?php

namespace App\Livewire\Language;

use Livewire\Component;

class Switcher extends Component
{
    public string $locale;

    public function mount()
    {
        $this->locale = app()->getLocale();
    }
    public function toggle()
    {
        $next = $this->locale === 'bg' ? 'en' : 'bg';
        // TODO: сетни сесия/куки + Redirect
        $this->locale = $next;
    }
    public function render()
    {
        return view('livewire.language.switcher');
    }
}
