<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Newsletter\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Domain\Newsletter\Repositories\EloquentNewsletterSubscriberRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            NewsletterSubscriberRepositoryInterface::class,
            EloquentNewsletterSubscriberRepository::class
        );
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
