<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserEmailEncryptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_is_encrypted_and_blind_index_works()
    {
        // Given (use Faker for dynamic values)
        $plaintextEmail = fake()->unique()->safeEmail();
        $firstName = 'John';
        $lastName = 'Doe';
        $normalized = Str::of($plaintextEmail)->lower()->trim();
        $hmacKey = base64_decode(Str::after(env('APP_BLIND_INDEX_KEY'), 'base64:'));
        $expectedBlindIndex = hash_hmac('sha256', $normalized, $hmacKey);

        // When
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $plaintextEmail,
            'password' => bcrypt('password'),
        ]);

        // Then: email should NOT be stored as plaintext in DB
        $rawDbUser = DB::table('users')->find($user->id);
        $this->assertNotEquals($plaintextEmail, $rawDbUser->email);

        // Extra: ensure no part of the user or email name appears in the encrypted value
        $this->assertStringNotContainsStringIgnoringCase(
            explode('@', $plaintextEmail)[0],
            $rawDbUser->email
        );
        $this->assertStringNotContainsStringIgnoringCase(
            strtolower($firstName),
            $rawDbUser->email
        );

        // Email should decrypt transparently
        $this->assertEquals($plaintextEmail, $user->email);

        // Blind index should match expected value
        $this->assertEquals($expectedBlindIndex, $rawDbUser->email_blind);

        // Can retrieve user via findByEmail
        $found = User::findByBlindIndex('email', $plaintextEmail);
        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
    }
}
