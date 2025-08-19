<?php

namespace App\Livewire\Language;

use Livewire\Component;

class Switcher extends Component
{
    public string $locale = 'bg';

    public function mount(): void
    {
        $this->locale = app()->getLocale();
    }

    public function toggle()
    {
        $next = $this->locale === 'bg' ? 'en' : 'bg';

        session(['locale' => $next]);
        cookie()->queue(cookie('locale', $next, 60 * 24 * 365 * 5, path: '/', secure: config('session.secure', false), httpOnly: true, sameSite: config('session.same_site', 'lax')));

        $this->locale = $next;

        return redirect(request()->header('Referer') ?: url()->current());
    }

    public function render()
    {
        return view('livewire.language.switcher');
    }
}
