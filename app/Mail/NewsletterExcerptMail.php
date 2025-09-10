<?php

namespace App\Mail;

use App\Models\NewsletterExcerpt;
use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterExcerptMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public NewsletterExcerpt $excerpt;
    public NewsletterSubscriber $subscriber;

    public function __construct(NewsletterExcerpt $excerpt, NewsletterSubscriber $subscriber)
    {
        $this->excerpt = $excerpt;
        $this->subscriber = $subscriber;
    }

    public function build()
    {
        return $this->subject('Нов откъс: ' . $this->excerpt->title)
            ->view('emails.newsletter-excerpt', [
                'title'          => $this->excerpt->title,
                'brandName'      => config('app.name'),
                'brandUrl'       => config('app.url'),
                'downloadUrl'    => route('newsletter.excerpt', $this->subscriber->token),
                'unsubscribeUrl' => route('newsletter.unsubscribe', $this->subscriber->token),
            ]);
    }
}
