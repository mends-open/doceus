<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Personnel;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_can_access_relations_via_ids()
    {
        $organization = Organization::create();
        $unit = Unit::create(['organization_id' => $organization->id]);
        $user = User::factory()->create();
        $personnel = Personnel::create([
            'unit_id' => $unit->id,
            'user_id' => $user->id,
        ]);

        $this->assertEquals($organization->id, $unit->organization->id);
        $this->assertTrue($organization->units->contains($unit));

        $this->assertEquals($unit->id, $personnel->unit->id);
        $this->assertTrue($unit->personnel->contains($personnel));

        $this->assertEquals($user->id, $personnel->user->id);
        $this->assertEquals($personnel->id, $user->personnel->id);
    }
}
