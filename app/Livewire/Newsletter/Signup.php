<?php

namespace App\Livewire\Newsletter;

use App\Domain\Newsletter\Services\NewsletterService;
use App\Http\Requests\Newsletter\SubscribeRequest;
use Livewire\Component;

class Signup extends Component
{
    public string $email = '';
    public bool $ok = false;
    public ?string $errorMessage = null;

    public function subscribe(NewsletterService $service)
    {
        $this->validate((new SubscribeRequest)->rules());

        try {
            $service->subscribe($this->email);
            $this->ok = true;
            $this->reset('email');

            $this->dispatch('notify', message: __('newsletter.subscribed'));
        } catch (\Throwable $e) {
            report($e);
            $this->errorMessage = __('newsletter.error');

            $this->dispatch('notify', message: __('newsletter.error_notify'));
        }
    }

    public function render()
    {
        return view('livewire.newsletter.signup');
    }
}
