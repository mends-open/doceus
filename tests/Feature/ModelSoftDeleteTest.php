<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Unit;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelSoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_are_soft_deleted()
    {
        $org = new Organization();
        $org->save();

        $unit = new Unit();
        $unit->organization_id = $org->id;
        $unit->save();

        $user = User::factory()->create();

        $personnel = new Personnel();
        $personnel->unit_id = $unit->id;
        $personnel->user_id = $user->id;
        $personnel->save();

        $org->delete();
        $unit->delete();
        $personnel->delete();
        $user->delete();

        $this->assertSoftDeleted('organizations', ['id' => $org->id]);
        $this->assertSoftDeleted('units', ['id' => $unit->id]);
        $this->assertSoftDeleted('personnel', ['id' => $personnel->id]);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
