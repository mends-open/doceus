<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Person;
use App\Models\Email;
use App\Models\Phone;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create some users
        $users = User::factory(5)->create();

        $organizations = collect();

        // Each user creates some organizations outside of tenancy
        $users->each(function (User $user) use (&$organizations) {
            Auth::login($user);
            Filament::setTenant(null);

            $created = Organization::factory(random_int(1, 3))->create();
            $organizations->push(...$created);

            $user->organizations()->attach($created->pluck('id'));

            Auth::logout();
        });

        // Attach additional users to random organizations
        $organizations->each(function (Organization $organization) use ($users) {
            $otherUsers = $users->random(random_int(0, $users->count() - 1));
            $organization->users()->syncWithoutDetaching($otherUsers->pluck('id'));
        });

        // Seed persons for each organization acting as a user within tenancy
        $organizations->each(function (Organization $organization) {
            $actingUser = $organization->users()->inRandomOrder()->first();

            if ($actingUser) {
                Auth::login($actingUser);
            }

            Filament::setTenant($organization);

            $emailsPool = Email::factory(random_int(10, 20))->create();
            $phonesPool = Phone::factory(random_int(10, 20))->create();

            Person::factory(random_int(5, 15))
                ->for($organization)
                ->create()
                ->each(function (Person $person) use ($emailsPool, $phonesPool) {
                    $person->emails()->attach($emailsPool->random(random_int(1, 2))->pluck('id'));
                    $person->phones()->attach($phonesPool->random(random_int(1, 2))->pluck('id'));
                });

            Auth::logout();
            Filament::setTenant(null);
        });
    }
}
