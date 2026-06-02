<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            $this->app['url']->forceScheme('https');
        }

        // Set asset URL to include subfolder path for cPanel hosting
        if (config('app.env') === 'production') {
            $this->app['url']->forceRootUrl(config('app.url'));
            $this->app['url']->forceScheme('https');
        }
    }
}
