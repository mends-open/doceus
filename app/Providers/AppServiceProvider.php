<?php

namespace App\Providers;

use App\Auth\BlindIndexUserProvider;
use App\Database\Views\MaterializedView;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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
        Schema::macro('createMaterializedView', function (string $name, Closure $callback): void {
            $view = new MaterializedView($name);
            $callback($view);
            $view->create();
        });

        Schema::macro('dropMaterializedView', function (string $name): void {
            (new MaterializedView($name))->dropIfExists();
        });

        Schema::macro('refreshMaterializedView', function (string $name, bool $concurrently = false): void {
            (new MaterializedView($name))->refresh($concurrently);
        });

        /**
         * Register the custom 'blindindex' user provider for encrypted email/blind index authentication.
         * Used for all user lookups in auth (including Filament).
         */
        Auth::provider('blindindex', function ($app, array $config) {
            return new BlindIndexUserProvider($app['hash'], $config['model']);
        });

    }
}
