<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register blade directives for translations

        // @lang('group.key') - Get translation from language line
        Blade::directive('lang', function ($expression) {
            return "<?php echo trans($expression); ?>";
        });

        // @translate('group', 'key') - Alias for @lang
        Blade::directive('translate', function ($expression) {
            return "<?php echo trans($expression); ?>";
        });

        // @pagecontent('page', 'key') - Get page content with translations
        Blade::directive('pagecontent', function ($expression) {
            $args = explode(',', $expression);
            $page = trim($args[0], " '\"");
            $key = trim($args[1], " '\"");
            return "<?php echo \\App\\Models\\PageContent::getByKey({$page}, {$key}) ?? ''; ?>";
        });

        // @haspagecontent('page', 'key') - Check if page content exists
        Blade::directive('haspagecontent', function ($expression) {
            $args = explode(',', $expression);
            $page = trim($args[0], " '\"");
            $key = trim($args[1], " '\"");
            return "<?php if(\\App\\Models\\PageContent::getByKey({$page}, {$key})): ?>";
        });

        // @endhaspagecontent - End directive
        Blade::directive('endhaspagecontent', function () {
            return "<?php endif; ?>";
        });

        // @locale() - Get current locale
        Blade::directive('locale', function () {
            return "<?php echo app()->getLocale(); ?>";
        });

        // @isrtl() - Check if current locale is RTL
        Blade::directive('isrtl', function () {
            return "<?php echo in_array(app()->getLocale(), ['ar']); ?>";
        });

        // @endisrtl - End RTL block
        Blade::directive('endisrtl', function () {
            return "<?php endif; ?>";
        });
    }
}
