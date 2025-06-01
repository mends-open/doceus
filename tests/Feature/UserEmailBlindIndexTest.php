<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserEmailBlindIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_by_email_returns_user()
    {
        // Given: generate a random but reproducible test email
        $plaintextEmail = fake()->unique()->safeEmail();
        $firstName = 'John';
        $lastName = 'Doe';

        // When
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $plaintextEmail,
            'password' => bcrypt('password'),
        ]);

        // Then: findByEmail should return the same user
        $found = User::findByBlindIndex('email', $plaintextEmail);

        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
        $this->assertEquals($plaintextEmail, $found->email);

        // The email in the DB should not be plaintext
        $rawDbUser = \DB::table('users')->find($user->id);
        $this->assertNotEquals($plaintextEmail, $rawDbUser->email);
        $this->assertStringNotContainsStringIgnoringCase(
            explode('@', $plaintextEmail)[0],
            $rawDbUser->email
        );

        // Blind index is correctly set (optional, for full test coverage)
        $normalized = Str::of($plaintextEmail)->lower()->trim();
        $hmacKey = base64_decode(Str::after(env('APP_BLIND_INDEX_KEY'), 'base64:'));
        $expectedBlindIndex = hash_hmac('sha256', $normalized, $hmacKey);
        $this->assertEquals($expectedBlindIndex, $rawDbUser->email_blind);
    }
}
