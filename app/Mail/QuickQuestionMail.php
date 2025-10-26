<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuickQuestionMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $message
    ) {}

    public function build()
    {
        return $this->subject('❓ Бърз въпрос от чатбота')
            ->from('support@izdatelstvo-satori.com', 'Издателство Сатори')
            ->to('info@izdatelstvo-satori.com')
            ->replyTo($this->email, $this->name)
            ->view('emails.faq.quick-question')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'message' => $this->message,
            ]);
    }
}
