<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleOrganizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_multiple_roles(): void
    {
        $user = User::factory()->create();

        Role::create(['user_id' => $user->id, 'name' => 'first']);
        Role::create(['user_id' => $user->id, 'name' => 'second']);

        $this->assertCount(2, $user->roles);
    }

    public function test_user_and_role_associations_with_organization(): void
    {
        $user = User::factory()->create();
        $org = Organization::create();
        $role = Role::create(['user_id' => $user->id, 'name' => 'owner']);

        $org->users()->attach($user);
        $org->roles()->attach($role);

        $this->assertTrue($org->users->contains($user));
        $this->assertTrue($org->roles->contains($role));
    }
}
