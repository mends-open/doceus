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

    public function test_create_contact_point_via_relationship_sets_type(): void
    {
        $person = Person::factory()->create();

        $person->contactPoints()->create([
            'system' => 'email',
            'value' => 'test@example.com',
        ]);

        $point = $person->contactPoints()->first();

        $this->assertNotNull($point);
        $this->assertSame('person', $point->contactable_type->value);
    }

    public function test_unused_scope_returns_only_unassigned(): void
    {
        ContactPoint::factory()->count(2)->email()->create();
        $unused = ContactPoint::factory()->count(3)->email()->unused()->create();

        $this->assertCount($unused->count(), ContactPoint::unused()->get());
    }

    public function test_contact_point_can_be_detached(): void
    {
        $point = ContactPoint::factory()->email()->create();

        $point->update(['contactable_id' => null]);

        $this->assertDatabaseHas('contact_points', [
            'id' => $point->id,
            'contactable_id' => null,
            'contactable_type' => null,
        ]);
    }
}
