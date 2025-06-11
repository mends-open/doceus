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

        $email = ContactPoint::factory()->email()->for($patient->person, 'person')->create();
        $phone = ContactPoint::factory()->phone()->for($patient->person, 'person')->create();
        $otherEmail = ContactPoint::factory()->email()->for($other->person, 'person')->create();

        $this->assertTrue($patient->contactPoints->contains($email));
        $this->assertTrue($patient->emails->contains($email));
        $this->assertTrue($patient->phones->contains($phone));
        $this->assertFalse($patient->emails->contains($otherEmail));
    }
}
