<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use SerializesModels;

    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject(__('auth.reset_password'))
            ->from('support@izdatelstvo-satori.com', 'Издателство Сатори')
            ->to(request('email'))
            ->view('emails.auth.reset-password')
            ->with([
                'url' => $this->url,
            ]);
    }
}
