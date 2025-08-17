<?php

namespace App\Livewire\Newsletter;

use Livewire\Component;

class Signup extends Component
{
    public string $email = '';
    public bool $ok = false;

    public function subscribe()
    {
        $this->validate(['email' => 'required|email']);
        // TODO: интеграция с Mailchimp/Sendinblue + изпращане на линк за PDF
        $this->ok = true;
        $this->reset('email');
    }

    public function render() { return view('livewire.newsletter.signup'); }
}
