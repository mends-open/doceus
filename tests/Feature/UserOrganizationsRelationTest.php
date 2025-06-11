<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserOrganizationsRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizations_relation_returns_only_practitioner_organizations(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $org1 = Organization::factory()->create();
        $org2 = Organization::factory()->create();

        $user->practitioner->organizations()->attach($org1);
        $other->practitioner->organizations()->attach($org2);

        $this->assertTrue($user->organizations->contains($org1));
        $this->assertFalse($user->organizations->contains($org2));
    }
}
