<?php

namespace App\Domain\Newsletter\Services;

use App\Domain\Newsletter\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Mail\NewsletterConfirm;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Throwable;

class NewsletterService
{
    public function __construct(
        private readonly NewsletterSubscriberRepositoryInterface $repo
    ) {}

    public function subscribe(string $email): void
    {
        $key = 'newsletter:subscribe:'.sha1(request()->ip().'|'.$email);
        if (RateLimiter::tooManyAttempts($key, 5)) {
            abort(429, 'Твърде много опити. Опитай отново след малко.');
        }
        RateLimiter::hit($key, 60);

        $existing = $this->repo->findByEmail($email);

        if (!$existing) {
            $sub = $this->repo->createPending($email, Str::random(40));
            $this->sendConfirmEmail($sub);
            return;
        }

        if ($existing->unsubscribed_at) {
            $sub = $this->repo->reactivate($existing, Str::random(40));
            $this->sendConfirmEmail($sub);
            return;
        }

        if ($existing->confirmed_at) {
            return;
        }

        $this->sendConfirmEmail($existing);
    }

    public function confirm(string $token): NewsletterSubscriber
    {
        $sub = $this->repo->findByToken($token);
        abort_unless($sub, 404, 'Невалиден токен.');
        abort_if($sub->unsubscribed_at, 410, 'Абонаментът е прекратен.');

        if (!$sub->confirmed_at) {
            $this->repo->confirm($sub);
        }

        return $sub;
    }

    public function unsubscribe(string $token): void
    {
        $sub = $this->repo->findByToken($token);
        abort_unless($sub, 404, 'Невалиден токен.');
        $this->repo->unsubscribe($sub);
    }

    protected function sendConfirmEmail(NewsletterSubscriber $sub): void
    {
        Mail::to($sub->email)->queue(new NewsletterConfirm($sub));
    }
}
