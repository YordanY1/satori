<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirm extends Mailable
{
    use SerializesModels;

    public function __construct(public NewsletterSubscriber $subscriber) {}

    public function build()
    {
        $confirmUrl = route('newsletter.confirm', $this->subscriber->token);
        $unsubscribeUrl = route('newsletter.unsubscribe', $this->subscriber->token);

        return $this->subject('📖 Потвърди своя абонамент и вземи безплатния откъс')
            ->from('support@izdatelstvo-satori.com', 'Издателство Сатори')
            ->to($this->subscriber->email)
            ->view('emails.newsletter-confirm', [
                'brandName' => config('app.name'),
                'brandUrl' => config('app.url'),
                'confirmUrl' => $confirmUrl,
                'unsubscribeUrl' => $unsubscribeUrl,
            ]);
    }
}
