<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Patient;
use App\Models\Person;
use App\Models\Practitioner;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $organizations = Organization::factory(5)->create();

        $practitioners = Practitioner::factory(5)->create();

        $practitioners->each(function (Practitioner $practitioner) use ($organizations) {
            // Each practitioner creates their own organization and is attached automatically
            $practitioner->createOrganization(Organization::factory()->make()->toArray());

            // Attach practitioner to a random subset of existing organizations
            $orgs = $organizations->random(random_int(1, $organizations->count()));
            $practitioner->organizations()->attach($orgs->pluck('id'));
        });

        User::factory(5)->create();

        // Seed additional persons for each organization
        $organizations->each(function (Organization $organization) {
            Person::factory(random_int(5, 15))
                ->create();

            $patients = Patient::factory(random_int(3, 8))
                ->create()
                ->each(function (Patient $patient) use ($organization) {
                    $patient->organizations()->attach($organization);
                });

        });
    }
}
