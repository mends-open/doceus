<?php

namespace App\Providers;

use App\Auth\BlindIndexUserProvider;
use App\Database\BlindIndexes\BlindIndexColumn;
use App\Database\Views\MaterializedView;
use App\Events\MaterializedViewNeedsRefresh;
use App\Listeners\RefreshMaterializedView;
use Closure;
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
        // For blind index columns (if you use this feature)
        Blueprint::macro('blind', function (string $column): BlindIndexColumn {
            return new BlindIndexColumn($this, $column);
        });

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

        // User provider macro registration, if you use blind-index auth
        Auth::provider('blindindex', function ($app, array $config) {
            return new BlindIndexUserProvider($app['hash'], $config['model']);
        });

        Event::listen(
            MaterializedViewNeedsRefresh::class,
            RefreshMaterializedView::class,
        );

        /**
         * Builder macro for "distinct on latest" for PostgreSQL usage.
         * Generates SQL like:
         *   SELECT DISTINCT ON (col1, col2, ...) * FROM ... ORDER BY col1, col2, ..., created_at DESC, id DESC
         */
        Builder::macro('distinctOnLatest', function (
            array $columns,
            string $orderByDesc = 'created_at',
            ?string $tiebreaker = 'id'
        ) {
            $on = implode(', ', $columns);

            // This resets the select and uses a raw SELECT for correct syntax
            $this->selectRaw("DISTINCT ON ($on) *");

            foreach ($columns as $column) {
                $this->orderBy($column);
            }

            $this->orderByDesc($orderByDesc);

            if ($tiebreaker) {
                $this->orderByDesc($tiebreaker);
            }

            return $this;
        });
    }
}
