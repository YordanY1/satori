<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordForm extends Component
{
    public string $email = '';
    public string $token = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ];

    public function mount($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', __('Password reset successful. You can now log in.'));
            return redirect()->route('login');
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password-form')
            ->layout('layouts.app', ['title' => __('Reset Password')]);
    }
}
