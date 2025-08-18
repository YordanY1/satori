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

            $this->dispatch('notify', message: '✅ Абонаментът е приет! Провери имейла си.');
        } catch (\Throwable $e) {
            report($e);
            $this->errorMessage = 'Възникна грешка. Опитай пак малко по-късно.';

            $this->dispatch('notify', message: '❌ Възникна грешка. Опитай пак.');
        }
    }


    public function render()
    {
        return view('livewire.newsletter.signup');
    }
}
