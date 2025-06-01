<?php

namespace App\Providers;

use App\Utilities\BlindIndex\Auth\BlindIndexUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(TelescopeServiceProvider::class)) {
            $this->app->register(TelescopeServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // User provider macro registration, if you use blind-index auth
        Auth::provider('blindindex', function ($app, array $config) {
            return new BlindIndexUserProvider($app['hash'], $config['model']);
        });

    }
}
