<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Encounter;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Person;
use App\Models\PractitionerQualification;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $organizations = Organization::factory(5)->create();

        $users = User::factory(5)->create();

        $users->each(function (User $user) use ($organizations) {
            // Each user creates their own organization and is attached automatically
            $user->createOrganization(Organization::factory()->make()->toArray());

            // Attach user to a random subset of existing organizations
            $orgs = $organizations->random(random_int(1, $organizations->count()));
            $user->practitioner->organizations()->attach($orgs->pluck('id'));

            PractitionerQualification::factory(random_int(1, 3))
                ->for($user->practitioner)
                ->create();
        });

        // Seed additional persons for each organization
        $organizations->each(function (Organization $organization) {
            Person::factory(random_int(5, 15))
                ->create();

            $patients = Patient::factory(random_int(3, 8))
                ->create()
                ->each(function (Patient $patient) use ($organization) {
                    $patient->organizations()->attach($organization);
                });

            $patients->each(function (Patient $patient) use ($organization) {
                Appointment::factory(random_int(1, 2))
                    ->for($patient)
                    ->for($organization)
                    ->for($organization->practitioners->random())
                    ->create()
                    ->each(function (Appointment $appointment) {
                        Encounter::factory(random_int(1, 3))
                            ->for($appointment)
                            ->create();
                    });
            });

            Tag::factory(random_int(2, 5))
                ->for($organization)
                ->create();
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("SELECT setval('tags_id_seq', (SELECT MAX(id) FROM tags))");
        }
    }
}
