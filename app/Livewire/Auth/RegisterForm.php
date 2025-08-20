<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterForm extends Component
{
    #[Validate('required|string|min:2|max:100')]
    public string $name = '';

    #[Validate('required|email:rfc,dns|unique:users,email')]
    public string $email = '';

    #[Validate('required|confirmed|min:8')]
    public string $password = '';
    
    public string $password_confirmation = '';

    public function register(): void
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);
        request()->session()->regenerate();

        $this->dispatch('notify', message: 'Добре дошъл!');
        $this->redirectIntended(route('profile.overview'));
    }

    public function render()
    {
        return view('livewire.auth.register-form');
    }
}
