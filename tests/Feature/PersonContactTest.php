<?php

namespace Tests\Feature;

use App\Feature\MorphClass\Enums\MorphClass;
use App\Feature\Revision\Enums\RevisionType;
use App\Feature\Revision\Models\Revision;
use App\Models\Email;
use App\Models\Person;
use App\Models\Phone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_manage_person_contacts(): void
    {
        $person = Person::factory()->create();
        $initial = Revision::count();

        // Attach emails and phones
        $person->emails()->saveMany($emails = Email::factory()->count(2)->make());
        $person->phones()->saveMany($phones = Phone::factory()->count(2)->make());

        $this->assertCount(2, $person->emails);
        $this->assertCount(2, $person->phones);
        $this->assertSame($initial + 4, Revision::count());

        // Update first email
        $email = $person->emails()->first();
        $email->update(['email' => 'updated@example.com']);
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Email->value,
            'revisionable_id' => $email->id,
            'type' => RevisionType::Updated->value,
        ]);

        // Detach one email
        $email->delete();
        $this->assertModelMissing($email);
        $this->assertCount(1, $person->refresh()->emails);
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => MorphClass::Email->value,
            'revisionable_id' => $email->id,
            'type' => RevisionType::Deleted->value,
        ]);

        // Sync phones
        $person->phones()->each(fn(Phone $p) => $p->delete());
        $person->phones()->saveMany(Phone::factory()->count(3)->make());
        $this->assertCount(3, $person->refresh()->phones);
    }
}
