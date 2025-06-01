<?php

namespace App\Providers;

use App\Utilities\Postgres\Macros\Blueprint;
use App\Utilities\Postgres\Macros\Builder;
use App\Utilities\Postgres\Macros\Schema;
use Illuminate\Support\ServiceProvider;

class MacrosServiceProvider extends ServiceProvider
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
    public function boot()
    {
        Builder::distinctOn();
        Blueprint::blind();
        Schema::createMaterializedView();
        Schema::dropMaterializedView();
        Schema::dropView();
        Schema::createView();
    }
}
