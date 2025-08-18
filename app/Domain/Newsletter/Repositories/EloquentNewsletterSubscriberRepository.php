<?php

namespace App\Domain\Newsletter\Repositories;

use App\Domain\Newsletter\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Models\NewsletterSubscriber;

class EloquentNewsletterSubscriberRepository implements NewsletterSubscriberRepositoryInterface
{
    public function findByEmail(string $email): ?NewsletterSubscriber
    {
        return NewsletterSubscriber::where('email', mb_strtolower($email))->first();
    }

    public function findByToken(string $token): ?NewsletterSubscriber
    {
        return NewsletterSubscriber::where('token', $token)->first();
    }

    public function createPending(string $email, string $token): NewsletterSubscriber
    {
        return NewsletterSubscriber::create([
            'email' => mb_strtolower($email),
            'token' => $token,
        ]);
    }

    public function confirm(NewsletterSubscriber $sub): NewsletterSubscriber
    {
        $sub->forceFill(['confirmed_at' => now()])->save();
        return $sub;
    }

    public function unsubscribe(NewsletterSubscriber $sub): NewsletterSubscriber
    {
        $sub->forceFill(['unsubscribed_at' => now()])->save();
        return $sub;
    }

    public function reactivate(NewsletterSubscriber $sub, string $newToken): NewsletterSubscriber
    {
        $sub->forceFill([
            'unsubscribed_at' => null,
            'confirmed_at' => null,
            'token' => $newToken,
        ])->save();

        return $sub;
    }
}
