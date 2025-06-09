<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserOrganizationCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_practitioner_created_when_user_is_created(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->practitioner);
        $this->assertDatabaseHas('practitioners', [
            'person_id' => $user->person_id,
        ]);
    }

    public function test_creating_organization_from_user_attaches_practitioner(): void
    {
        $user = User::factory()->create();
        $attributes = Organization::factory()->make()->toArray();

        $organization = $user->createOrganization($attributes);

        $this->assertDatabaseHas('organization_practitioner', [
            'organization_id' => $organization->id,
            'practitioner_id' => $user->practitioner->id,
        ]);
    }
}
