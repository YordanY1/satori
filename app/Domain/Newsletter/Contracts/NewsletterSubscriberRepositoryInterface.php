<?php

namespace App\Domain\Newsletter\Contracts;

use App\Models\NewsletterSubscriber;

interface NewsletterSubscriberRepositoryInterface
{
    public function findByEmail(string $email): ?NewsletterSubscriber;
    public function findByToken(string $token): ?NewsletterSubscriber;

    public function createPending(string $email, string $token): NewsletterSubscriber;

    public function confirm(NewsletterSubscriber $sub): NewsletterSubscriber;
    public function unsubscribe(NewsletterSubscriber $sub): NewsletterSubscriber;

    public function reactivate(NewsletterSubscriber $sub, string $newToken): NewsletterSubscriber;
}
