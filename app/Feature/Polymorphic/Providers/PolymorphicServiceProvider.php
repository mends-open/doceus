<?php

namespace App\Feature\Polymorphic\Providers;

use App\Feature\Polymorphic\Enums\MorphType;
use App\Models\Organization;
use App\Models\OrganizationPatient;
use App\Models\OrganizationPractitioner;
use App\Models\Patient;
use App\Models\PatientPractitioner;
use App\Models\Person;
use App\Models\Practitioner;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class PolymorphicServiceProvider extends ServiceProvider
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
            MorphType::User->value => User::class,
            MorphType::Person->value => Person::class,
            MorphType::Practitioner->value => Practitioner::class,
            MorphType::Patient->value => Patient::class,
            MorphType::Organization->value => Organization::class,
            MorphType::OrganizationPractitioner->value => OrganizationPractitioner::class,
            MorphType::OrganizationPatient->value => OrganizationPatient::class,
            MorphType::PatientPractitioner->value => PatientPractitioner::class,
        ]);
    }
}
