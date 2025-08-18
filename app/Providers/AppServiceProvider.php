<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Newsletter\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Domain\Newsletter\Repositories\EloquentNewsletterSubscriberRepository;
use App\Domain\Econt\Contracts\EcontGateway;
use App\Domain\Econt\Gateways\GdinkoEcontGateway;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            NewsletterSubscriberRepositoryInterface::class,
            EloquentNewsletterSubscriberRepository::class
        );

        $this->app->bind(
            EcontGateway::class,
            GdinkoEcontGateway::class
        );
    }

    public function boot(): void
    {
        //
    }
}
