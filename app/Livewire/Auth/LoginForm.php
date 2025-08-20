<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class LoginForm extends Component
{
    #[Validate('required|email:rfc,dns')]
    public string $email = '';

    #[Validate('required|string|min:6')]
    public string $password = '';

    public bool $remember = false;

    protected function throttleKey(): string
    {
        return Str::lower($this->email) . '|' . request()->ip();
    }

    public function login(): void
    {
        $this->validate();

        $key = $this->throttleKey();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Твърде много опити. Опитай след {$seconds} сек."
            ]);
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages([
                'email' => 'Невалидни данни за вход.'
            ]);
        }

        RateLimiter::clear($key);
        request()->session()->regenerate();

        $this->dispatch('notify', message: 'Успешен вход!');
        $this->redirectIntended(route('profile.overview'));
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
