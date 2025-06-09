<?php

namespace App\Feature\MorphClass\Providers;

use App\Feature\MorphClass\Enums\MorphClass;
use App\Models\Organization;
use App\Models\OrganizationUser;
use App\Models\Person;
use App\Models\ContactPoint;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class MorphClassServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        Relation::enforceMorphMap([
            MorphClass::Organization->value => Organization::class,
            MorphClass::User->value => User::class,
            MorphClass::OrganizationUser->value => OrganizationUser::class,
            MorphClass::Person->value => Person::class,
            MorphClass::ContactPoint->value => ContactPoint::class,
        ]);
    }
}
