<?php


namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirm extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public NewsletterSubscriber $subscriber) {}

    public function build()
    {
        $confirmUrl     = route('newsletter.confirm', $this->subscriber->token);
        $unsubscribeUrl = route('newsletter.unsubscribe', $this->subscriber->token);

        return $this->subject('Потвърди абонамента и вземи безплатния откъс')
            ->view('emails.newsletter-confirm', [
                'brandName'       => config('app.name'),
                'brandUrl'        => config('app.url'),
                'confirmUrl'      => $confirmUrl,
                'unsubscribeUrl'  => $unsubscribeUrl,
            ])
            ->text('emails.newsletter-confirm-text', [
                'confirmUrl'     => $confirmUrl,
                'unsubscribeUrl' => $unsubscribeUrl,
            ]);
    }
}
