<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Unit;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_have_expected_relationships(): void
    {
        $org = Organization::create();
        $unit = Unit::create(['organization_id' => $org->id]);
        $user = User::factory()->create();
        $personnel = Personnel::create([
            'unit_id' => $unit->id,
            'user_id' => $user->id,
        ]);

        // Organization relations
        $this->assertTrue($org->units->contains($unit));
        $this->assertTrue($org->personnel->contains($personnel));

        // Unit relations
        $this->assertTrue($unit->organization->is($org));
        $this->assertTrue($unit->personnel->contains($personnel));
        $this->assertTrue($unit->users->contains($user));

        // Personnel relations
        $this->assertTrue($personnel->unit->is($unit));
        $this->assertTrue($personnel->user->is($user));

        // User relations
        $this->assertTrue($user->personnel->contains($personnel));
        $this->assertTrue($user->units->contains($unit));
    }
}
