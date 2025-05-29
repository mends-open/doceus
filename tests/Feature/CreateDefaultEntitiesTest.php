<?php

namespace Tests\Feature;

use App\Enums\OrganizationType;
use App\Enums\RoleType;
use App\Jobs\CreateDefaultEntities;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateDefaultEntitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_creates_related_entities(): void
    {
        $user = User::create([
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $job = new CreateDefaultEntities($user->id, RoleType::IS_MEDICAL_DOCTOR);
        $job->handle();

        $role = Role::first();
        $organization = Organization::first();

        $this->assertNotNull($role);
        $this->assertNotNull($organization);
        $this->assertEquals($user->id, $role->user_id);
        $this->assertEquals(RoleType::IS_MEDICAL_DOCTOR, $role->type);
        $this->assertEquals(OrganizationType::INDIVIDUAL, $organization->type);
        $this->assertDatabaseHas('organization_user', [
            'organization_id' => $organization->id,
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('organization_role', [
            'organization_id' => $organization->id,
            'role_id' => $role->id,
        ]);
        $this->assertEquals($role->id, $user->fresh()->default_role_id);
    }
}
