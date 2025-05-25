<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserBlindIndexLookupTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_by_email_works_with_blind_index()
    {
        $email = fake()->unique()->safeEmail();
        $firstName = 'John';
        $lastName = 'Doe';

        // Create user as normal
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => bcrypt('password'),
        ]);

        // Lookup by blind index
        $found = User::findByBlindIndex('email', $email);

        // Should be found, and email should match
        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
        $this->assertEquals($email, $found->email);
    }
}
