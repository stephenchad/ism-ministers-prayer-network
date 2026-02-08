<?php

namespace App\Providers;

use App\Services\CommerceApiClient;
use Illuminate\Support\ServiceProvider;

class CommerceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CommerceApiClient::class, function ($app) {
            // Only create if commerce config is properly set
            if (config('services.commerce.api_key') && config('services.commerce.api_secret')) {
                return new CommerceApiClient();
            }
            // Return null if not configured (will be handled by controllers)
            return null;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
