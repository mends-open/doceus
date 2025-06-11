<?php

namespace Tests\Feature;

use App\Models\ContactPoint;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientContactPointsRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_contact_points_relation(): void
    {
        $patient = Patient::factory()->create();
        $other = Patient::factory()->create();

        $point1 = ContactPoint::factory()->for($patient->person, 'person')->create();
        $point2 = ContactPoint::factory()->for($other->person, 'person')->create();

        $this->assertTrue($patient->contactPoints->contains($point1));
        $this->assertFalse($patient->contactPoints->contains($point2));
    }
}
