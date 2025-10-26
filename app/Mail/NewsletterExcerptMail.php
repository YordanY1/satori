<?php

namespace App\Mail;

use App\Models\NewsletterExcerpt;
use App\Models\NewsletterSubscriber;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterExcerptMail extends Mailable
{
    use SerializesModels;

    public NewsletterExcerpt $excerpt;

    public NewsletterSubscriber $subscriber;

    public function __construct(NewsletterExcerpt $excerpt, NewsletterSubscriber $subscriber)
    {
        $this->excerpt = $excerpt;
        $this->subscriber = $subscriber;
    }

    public function build()
    {
        $downloadUrl = route('newsletter.excerpt', $this->subscriber->token);
        $unsubscribeUrl = route('newsletter.unsubscribe', $this->subscriber->token);

        return $this->subject('📚 Нов откъс: '.$this->excerpt->title)
            ->from('support@izdatelstvo-satori.com', 'Издателство Сатори')
            ->to($this->subscriber->email)
            ->view('emails.newsletter-excerpt', [
                'title' => $this->excerpt->title,
                'brandName' => config('app.name'),
                'brandUrl' => config('app.url'),
                'downloadUrl' => $downloadUrl,
                'unsubscribeUrl' => $unsubscribeUrl,
            ])
            ->text('emails.newsletter-excerpt-text', [
                'title' => $this->excerpt->title,
                'downloadUrl' => $downloadUrl,
                'unsubscribeUrl' => $unsubscribeUrl,
            ]);
    }
}
