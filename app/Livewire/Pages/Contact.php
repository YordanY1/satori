<?php

namespace App\Livewire\Pages;

use App\Mail\ContactMessage;
use App\Models\Contact as ContactModel;
use App\Rules\RecaptchaV2;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class Contact extends Component
{
    public $name;

    public $email;

    public $message;

    // reCAPTCHA & honeypot
    public $recaptcha = '';

    public $website = '';

    public array $seo = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
            'recaptcha' => ['required', new RecaptchaV2],
            'website' => 'prohibited|size:0',
        ];
    }

    public function mount(): void
    {
        $this->seo = [
            'title' => 'Контакти — Издателство Сатори',
            'description' => 'Свържи се с Издателство Сатори — адрес, телефон, имейл и форма за запитвания. Нашият екип ще отговори възможно най-бързо.',
            'keywords' => 'издателство сатори, контакти, адрес, телефон, имейл, връзка, овча купел, софия',
            'canonical' => url()->current(),
            'og:title' => 'Контакти — Издателство Сатори',
            'og:description' => 'Официални контакти на Издателство Сатори: имейл, телефон, адрес и форма за запитвания.',
            'og:url' => url()->current(),
            'og:type' => 'website',
            'og:image' => asset('images/og/contact.jpg'),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Контакти — Издателство Сатори',
            'twitter:description' => 'Свържи се с Издателство Сатори — адрес, телефон, имейл и контактна форма.',
            'twitter:image' => asset('images/og/contact.jpg'),

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => 'Контакти — Издателство Сатори',
                'description' => 'Официална страница за връзка с Издателство Сатори. Намери нашите контакти, имейл, телефон и адрес в София.',
                'url' => url()->current(),
                'publisher' => [
                    '@type' => 'Organization',
                    '@id' => url('#organization'),
                    'name' => 'Издателство Сатори',
                    'alternateName' => 'Сатори Ко',
                    'url' => url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('images/logo.png'),
                    ],
                    'sameAs' => [
                        'https://www.facebook.com/VBelenski',
                    ],
                    'contactPoint' => [
                        [
                            '@type' => 'ContactPoint',
                            'contactType' => 'Customer Support',
                            'telephone' => '+359 87 849 0782',
                            'email' => 'satorico@abv.bg',
                            'areaServed' => 'BG',
                            'availableLanguage' => ['Bulgarian', 'English'],
                        ],
                    ],
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'ж.к. Овча Купел 1, бл. 411, магазин 2',
                        'addressLocality' => 'София',
                        'postalCode' => '1632',
                        'addressCountry' => 'BG',
                    ],
                ],
            ],
        ];
    }

    public function submit()
    {
        $key = 'contact:'.request()->ip();

        RateLimiter::attempt($key, $perMinute = 3, function () {}, $decaySeconds = 60);

        if (RateLimiter::tooManyAttempts($key, $perMinute)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('name', __('contact.rate_limit', ['sec' => $seconds]));

            return;
        }

        $validated = $this->validate();

        $contact = ContactModel::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        Mail::to('satorico@abv.bg')->send(new ContactMessage($contact));

        session()->flash('success', __('contact.success'));
        $this->reset(['name', 'email', 'message', 'recaptcha', 'website']);
        $this->dispatch('recaptcha-reset');
    }

    public function render()
    {
        return view('livewire.pages.contact', [
            'recaptchaSiteKey' => config('services.recaptcha.site_key'),
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
