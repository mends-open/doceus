<?php

namespace Tests\Feature;

use App\Feature\Polymorphic\Enums\MorphType;
use App\Feature\Revision\Enums\RevisionType;
use App\Feature\Revision\Models\Revision;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonContactsTest extends TestCase
{
    use RefreshDatabase;

    public function test_manage_person_contacts(): void
    {
        $person = Person::factory()->create([
            'emails' => ['first@example.com', 'second@example.com'],
            'phone_numbers' => ['123-456-789', '987-654-321'],
        ]);

        $initial = Revision::count();

        // Update first email
        $emails = $person->emails;
        $emails[0] = 'updated@example.com';
        $person->update(['emails' => $emails]);

        $this->assertSame($initial + 1, Revision::count());
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphType::Person->value,
            'revisionable_id' => $person->id,
            'type' => RevisionType::Updated->value,
        ]);

        // Remove a phone number
        $phones = $person->phone_numbers;
        array_shift($phones);
        $person->update(['phone_numbers' => $phones]);
        $this->assertCount(1, $person->refresh()->phone_numbers);

        // Add new phone number
        $person->update(['phone_numbers' => [...$person->phone_numbers, '555-555-555']]);
        $this->assertCount(2, $person->refresh()->phone_numbers);
    }
}
