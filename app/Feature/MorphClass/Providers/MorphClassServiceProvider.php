<?php

namespace App\Feature\MorphClass\Providers;

use App\Feature\MorphClass\Enums\MorphClass;
use App\Models\Organization;
use App\Models\OrganizationPatient;
use App\Models\OrganizationPractitioner;
use App\Models\Patient;
use App\Models\Person;
use App\Models\ContactPoint;
use App\Models\Practitioner;
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
            MorphClass::User->value => User::class,
            MorphClass::Person->value => Person::class,
            MorphClass::Practitioner->value => Practitioner::class,
            MorphClass::Patient->value => Patient::class,
            MorphClass::Organization->value => Organization::class,
            MorphClass::OrganizationPractitioner->value => OrganizationPractitioner::class,
            MorphClass::OrganizationPatient->value => OrganizationPatient::class,
            MorphClass::PatientPractitioner->value => OrganizationPractitioner::class,
            MorphClass::PractitionerQualification->value => OrganizationPractitioner::class,
            MorphClass::ContactPoint->value => ContactPoint::class,
        ]);
    }
}
