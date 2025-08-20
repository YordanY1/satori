<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use App\Rules\RecaptchaV2;
use App\Models\Contact as ContactModel;
use App\Mail\ContactMessage;


class Contact extends Component
{
    public $name;
    public $email;
    public $message;

    // reCAPTCHA & honeypot
    public $recaptcha = '';
    public $website = '';

    protected function rules()
    {
        return [
            'name'     => 'required|string|min:2',
            'email'    => 'required|email',
            'message'  => 'required|string|min:10',
            'recaptcha' => ['required', new RecaptchaV2],
            'website'  => 'prohibited|size:0',
        ];
    }

    public function submit()
    {

        $key = 'contact:' . request()->ip();
        RateLimiter::attempt($key, $perMinute = 3, function () {}, $decaySeconds = 60);
        if (RateLimiter::tooManyAttempts($key, $perMinute)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('name', __('Твърде много опити. Опитайте след :sec сек.', ['sec' => $seconds]));
            return;
        }

        $validated = $this->validate();

        $contact = ContactModel::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'message' => $this->message,
        ]);


        Mail::to('info@satori-ko.bg')->send(new ContactMessage($contact));

        session()->flash('success', 'Благодарим! Ще се свържем с вас скоро.');
        $this->reset(['name', 'email', 'message', 'recaptcha', 'website']);
        $this->dispatch('recaptcha-reset');
    }

    public function render()
    {
        return view('livewire.pages.contact', [
            'recaptchaSiteKey' => config('services.recaptcha.site_key'),
        ])->layout('layouts.app', [
            'title' => 'Контакт — Сатори Ко',
        ]);
    }
}
