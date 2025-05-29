<?php

namespace App\Jobs;

use App\Enums\OrganizationType;
use App\Enums\RoleType;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class CreateDefaultEntities implements ShouldQueue, ShouldBeEncrypted
{
    use Dispatchable, Queueable;

    public function __construct(public string $userId, public RoleType $roleType)
    {
    }

    public function handle(): void
    {
        DB::transaction(function () {
            $user = User::findOrFail($this->userId);

            $role = Role::create([
                'user_id' => $user->id,
                'type' => $this->roleType,
            ]);

            $organization = Organization::create([
                'type' => OrganizationType::INDIVIDUAL,
            ]);

            $organization->users()->attach($user->id);
            $organization->roles()->attach($role->id);

            $user->default_role_id = $role->id;
            $user->save();
        });
    }
}
