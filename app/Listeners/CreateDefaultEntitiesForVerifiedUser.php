<?php

namespace App\Listeners;

use App\Enums\OrganizationType;
use App\Enums\UnitType;
use App\Models\Organization;
use App\Models\Role;
use App\Models\Unit;
use App\Services\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDefaultEntitiesForVerifiedUser implements ShouldBeEncrypted, ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $user = $event->user;

        DB::transaction(function () use ($user) {
            $organization = Organization::create([
                //'type' => OrganizationType::NATURAL_PERSON,
            ]);

            Tenant::set($organization);

            $unit = Unit::create([
                'organization_id' => $organization->id,
                //'type' => UnitType::WITHOUT_PRACTICE,
            ]);

            $organization->users()->attach($user);

            $role = Role::create([
                'user_id' => $user->id,
                'name' => 'owner',
            ]);

            $organization->roles()->attach($role);
        });
    }
}
