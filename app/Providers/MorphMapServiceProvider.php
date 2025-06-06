<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class MorphMapServiceProvider extends ServiceProvider
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
    public static function boot(): void
    {
        Relation::enforceMorphMap([
            // Short aliases for morph types
            'person'        => \App\Models\Person::class,
            'organization'  => \App\Models\Organization::class,
            'organization_user'  => \App\Models\OrganizationUser::class,
            'user'          => \App\Models\User::class,
            'revision'      => \App\Models\Revision::class,
        ]);
    }
}
