<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Person;
use App\Models\ContactPoint;
use App\Models\Practitioner;
use App\Models\OrganizationPractitioner;
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

        $users = User::factory(5)->create();

        $users->each(function (User $user) use ($organizations) {
            $practitioner = Practitioner::create(['person_id' => $user->person_id]);
            $orgs = $organizations->random(random_int(1, $organizations->count()));
            $practitioner->organizations()->attach($orgs->pluck('id'));
        });

        // Seed additional persons for each organization
        $organizations->each(function (Organization $organization) {
            Person::factory(random_int(5, 15))
                ->create()
                ->each(function (Person $person) {
                    ContactPoint::factory(random_int(1, 2))
                        ->for($person, 'person')
                        ->email()
                        ->create();

                    ContactPoint::factory(random_int(1, 2))
                        ->for($person, 'person')
                        ->phone()
                        ->create();
                });
        });
    }
}
