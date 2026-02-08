<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\NotificationComposer;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load custom form helpers
        require_once app_path('Helpers/FormHelper.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Paginator::useBootstrapFive();

        // Share notification data with all views in the 'admin' and 'front' namespaces.
        View::composer(['admin.*', 'front.*'], NotificationComposer::class);
    }
}
