<?php

namespace App\Livewire\Profile;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Settings extends Component
{
    #[Validate('required|string|min:2|max:100')]
    public string $name = '';

    #[Validate]
    public string $email = '';

    #[Validate('nullable|string|min:8|max:30')]
    public ?string $phone = '';

    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount(): void
    {
        $u = Auth::user();
        $this->name  = (string) $u->name;
        $this->email = (string) $u->email;
        $this->phone = (string) ($u->phone ?? '');
    }

    protected function rules(): array
    {
        $userId = Auth::id();

        return [
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'current_password' => ['nullable', 'current_password:web'],
            'new_password'     => ['nullable', 'confirmed', Password::defaults()],
        ];
    }

    public function updateProfile(): void
    {
        $this->validateOnly('name');
        $this->validateOnly('email');

        $user = Auth::user();

        $user->fill([
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
        ])->save();

        // if ($user->wasChanged('email') && $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
        //     $user->forceFill(['email_verified_at' => null])->save();
        //     $user->sendEmailVerificationNotification();
        // }

        $this->dispatch('notify', message: 'Профилът е обновен ✅');
    }

    public function updatePassword(): void
    {
        if (trim($this->new_password) === '') {
            $this->addError('new_password', 'Моля, въведи нова парола.');
            return;
        }

        $this->validateOnly('current_password');
        $this->validateOnly('new_password');

        $user = Auth::user();

        $user->forceFill([
            'password' => $this->new_password,
        ])->save();

        request()->session()->regenerate();

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        $this->dispatch('notify', message: 'Паролата е сменена 🔒');
    }

    public function render(): View
    {
        return view('livewire.profile.settings')->layout('layouts.app');
    }
}
