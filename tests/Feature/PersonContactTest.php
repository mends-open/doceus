<?php

namespace Tests\Feature;

use App\Feature\Polymorphic\Enums\MorphType;
use App\Feature\Revision\Enums\RevisionType;
use App\Feature\Revision\Models\Revision;
use App\Models\ContactPoint;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_manage_person_contacts(): void
    {
        $person = Person::factory()->create();
        $initial = Revision::count();

        // Create contact points
        $emails = ContactPoint::factory()->count(2)
            ->for($person, 'person')
            ->email()
            ->create();
        $phones = ContactPoint::factory()->count(2)
            ->for($person, 'person')
            ->phone()
            ->create();

        $this->assertCount(4, $person->contactPoints);
        $this->assertSame($initial + 4, Revision::count());

        // Update first email
        $email = $emails->first();
        $email->update(['value' => 'updated@example.com']);
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphType::ContactPoint->value,
            'revisionable_id' => $email->id,
            'type' => RevisionType::Updated->value,
        ]);

        // Delete one email
        $emailId = $email->id;
        $email->delete();
        $this->assertCount(3, $person->refresh()->contactPoints);
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphType::ContactPoint->value,
            'revisionable_id' => $emailId,
            'type' => RevisionType::Deleted->value,
        ]);

        // Add additional phones
        ContactPoint::factory()->count(3)
            ->for($person, 'person')
            ->phone()
            ->create();
        $this->assertCount(6, $person->refresh()->contactPoints);
    }
}
