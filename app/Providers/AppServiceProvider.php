<?php

namespace App\Providers;

use App\Domain\Newsletter\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Domain\Newsletter\Repositories\EloquentNewsletterSubscriberRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        // Fix for older MySQL versions (e.g. 5.6, 5.5, MariaDB 10.0)
        Schema::defaultStringLength(191);
    }
}
