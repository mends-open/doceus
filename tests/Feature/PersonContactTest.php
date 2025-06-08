<?php

namespace Tests\Feature;

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

        // Attach emails and phones
        $person->emails()->saveMany(Email::factory()->count(2)->make());
        $person->phones()->saveMany(Phone::factory()->count(2)->make());

        $this->assertCount(2, $person->emails);
        $this->assertCount(2, $person->phones);

        // Detach one email
        $email = $person->emails()->first();
        $email->delete();
        $this->assertModelMissing($email);
        $this->assertCount(1, $person->refresh()->emails);

        // Sync phones
        $person->phones()->delete();
        $person->phones()->saveMany(Phone::factory()->count(3)->make());
        $this->assertCount(3, $person->refresh()->phones);
    }
}
