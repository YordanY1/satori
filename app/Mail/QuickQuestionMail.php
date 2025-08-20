<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuickQuestionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $message
    ) {}

    public function build()
    {
        return $this->subject('❓ Бърз въпрос от чатбота')
            ->view('emails.faq.quick-question')
            ->with([
                'name'    => $this->name,
                'email'   => $this->email,
                'message' => $this->message,
            ]);
    }
}
