<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Personnel;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_units_relationship(): void
    {
        $user = User::factory()->create();
        $organization = Organization::create();
        $unit = Unit::create(['organization_id' => $organization->id]);

        Personnel::create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
        ]);

        $this->assertTrue($user->units->contains($unit));
    }

    public function test_verified_event_creates_default_entities(): void
    {
        $user = User::factory()->create();

        event(new Verified($user));

        $this->assertDatabaseCount('organizations', 1);
        $this->assertDatabaseCount('units', 1);
        $this->assertDatabaseCount('personnel', 1);

        $this->assertDatabaseHas('personnel', [
            'user_id' => $user->id,
        ]);
    }
}
