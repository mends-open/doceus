<?php

namespace App\Providers;

use App\Utilities\Postgres\Macros\Blueprint;
use App\Utilities\Postgres\Macros\Schema;
use Illuminate\Support\ServiceProvider;
use App\Utilities\Postgres\Macros\Builder;

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
        Schema::materializedView();
        Schema::dropMaterializedView();
    }
}
