<?php

namespace App\Providers;

use App\Utilities\BlindIndex\Auth\BlindIndexUserProvider;
use App\Utilities\BlindIndex\BlindIndexColumn;
use App\Utilities\MaterializedView\Events\MaterializedViewNeedsRefresh;
use App\Utilities\MaterializedView\Listeners\RefreshMaterializedView;
use App\Utilities\MaterializedView\MaterializedView;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
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

        // User provider macro registration, if you use blind-index auth
        Auth::provider('blindindex', function ($app, array $config) {
            return new BlindIndexUserProvider($app['hash'], $config['model']);
        });

        Event::listen(
            MaterializedViewNeedsRefresh::class,
            RefreshMaterializedView::class,
        );
    }
}
