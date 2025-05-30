<?php

namespace App\Providers;

use App\Auth\BlindIndexUserProvider;
use App\Events\MaterializedViewNeedsRefresh;
use App\Listeners\RefreshMaterializedView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
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
        /**
         * Register the custom 'blindindex' user provider for encrypted email/blind index authentication.
         * Used for all user lookups in auth (including Filament).
         */
        Auth::provider('blindindex', function ($app, array $config) {
            return new BlindIndexUserProvider($app['hash'], $config['model']);
        });

        Event::listen(
            MaterializedViewNeedsRefresh::class,
            RefreshMaterializedView::class,
        );

    }
}
