<?php

namespace App\Providers;

use App\Auth\EloquentBlindIndexUserProvider;
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
            $this->app->register(TelescopeServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Register the custom 'blindindex' user provider for encrypted email/blind index authentication.
         * Used for all user lookups in auth (including Filament).
         */
        Auth::provider('blindindex', function ($app, array $config) {
            return new EloquentBlindIndexUserProvider($app['hash'], $config['model']);
        });

    }
}
