<?php

namespace App\Livewire\Faq;

use App\Mail\QuickQuestionMail;
use App\Models\Faq;
use App\Rules\RecaptchaV2;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class Widget extends Component
{
    public string $q = '';

    public array $results = [];

    public array $suggested = [];

    public bool $open = false;

    public string $contact_name = '';

    public string $contact_email = '';

    public string $contact_message = '';

    public string $recaptcha = '';

    public string $website = '';

    protected function rules()
    {
        return [
            'contact_name' => 'required|string|min:2',
            'contact_email' => 'required|email',
            'contact_message' => 'required|string|min:10',
            'recaptcha' => ['required', new RecaptchaV2],
            'website' => 'prohibited|size:0',
        ];
    }

    public function mount(): void
    {
        $this->suggested = Faq::where('is_active', true)
            ->latest()->take(5)->get(['id', 'question', 'answer'])->toArray();

        $this->results = $this->suggested;
    }

    public function updatedQ(): void
    {
        $this->search();
    }

    public function search(): void
    {
        $this->results = Faq::search($this->q)->take(8)->get(['id', 'question', 'answer'])->toArray();
    }

    public function quickAsk(): void
    {

        $key = 'faqwidget:'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('contact_name', __('Твърде много опити. Опитайте след :sec сек.', ['sec' => $seconds]));

            return;
        }
        RateLimiter::hit($key, 60);

        $data = $this->validate();

        try {
            Mail::to('support@izdatelstvo-satori.com')->send(
                new QuickQuestionMail(
                    name: $this->contact_name,
                    email: $this->contact_email,
                    message: $this->contact_message
                )
            );
        } catch (\Throwable $e) {
            report($e);
            $this->addError('contact_name', 'Възникна грешка при изпращане. Опитайте отново.');

            return;
        }

        $this->dispatch('notify', message: 'Получихме съобщението ти. Ще се свържем скоро.');
        $this->reset(['contact_name', 'contact_email', 'contact_message', 'recaptcha', 'website']);
        $this->dispatch('recaptcha-reset');
        $this->open = false;
    }

    public function fillFromSuggestion($id): void
    {
        $row = Faq::find($id);
        if ($row) {
            $this->q = $row->question;
            $this->results = [$row->only(['id', 'question', 'answer'])];
        }
    }

    public function render()
    {
        return view('livewire.faq.widget');
    }
}
