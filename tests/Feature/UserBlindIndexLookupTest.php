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
        $name = fake()->name();

        // Create user as normal
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt('password'),
        ]);

        // Lookup by blind index
        $found = User::findByEmail($email);

        // Should be found, and email should match
        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
        $this->assertEquals($email, $found->email);
    }
}
