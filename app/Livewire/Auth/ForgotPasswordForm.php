<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;

class ForgotPasswordForm extends Component
{
    public string $email = '';

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', __('Check your email for reset link.'));
        } else {
            $this->addError('email', __('Unable to send reset link.'));
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-form')
            ->layout('layouts.app', ['title' => __('Forgot Password')]);
    }
}
