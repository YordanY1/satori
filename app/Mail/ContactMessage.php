<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Mail\Mailable;

class ContactMessage extends Mailable
{
    public function __construct(public Contact $contact) {}

    public function build()
    {
        return $this->subject('📩 Ново съобщение от контактната форма')
            ->from('support@izdatelstvo-satori.com', 'Издателство Сатори')
            ->replyTo($this->contact->email, $this->contact->name ?? 'Потребител')
            ->view('emails.contact.message')
            ->with(['contact' => $this->contact]);
    }
}
