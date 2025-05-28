<?php

namespace Tests\Feature;

use App\Enums\OrganizationType;
use App\Enums\PersonnelType;
use App\Enums\UnitType;
use App\Models\Organization;
use App\Models\Personnel;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelEnumCastTest extends TestCase
{
    use RefreshDatabase;

    public function test_types_are_cast_to_enums()
    {
        $org = Organization::create([
            'type' => OrganizationType::LEGAL_ENTITY,
        ]);

        $this->assertInstanceOf(OrganizationType::class, $org->type);
        $this->assertSame(OrganizationType::LEGAL_ENTITY, $org->fresh()->type);

        $unit = Unit::create([
            'organization_id' => $org->id,
            'type' => UnitType::WITHOUT_PRACTICE,
        ]);

        $this->assertInstanceOf(UnitType::class, $unit->type);
        $this->assertSame(UnitType::WITHOUT_PRACTICE, $unit->fresh()->type);

        $user = User::factory()->create();

        $personnel = Personnel::create([
            'unit_id' => $unit->id,
            'user_id' => $user->id,
            'type' => PersonnelType::MEDICAL_ASSISTANT,
        ]);

        $this->assertInstanceOf(PersonnelType::class, $personnel->type);
        $this->assertSame(PersonnelType::MEDICAL_ASSISTANT, $personnel->fresh()->type);
    }
}
