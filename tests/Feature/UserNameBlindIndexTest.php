<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserNameBlindIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_first_and_last_name_blind_indexes_are_created()
    {
        $firstName = 'Alice';
        $lastName = 'Smith';
        $email = fake()->unique()->safeEmail();

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => bcrypt('password'),
        ]);

        $rawDbUser = \DB::table('users')->find($user->id);

        $normalizedFirst = Str::of($firstName)->lower()->trim();
        $normalizedLast = Str::of($lastName)->lower()->trim();
        $hmacKey = base64_decode(Str::after(env('APP_BLIND_INDEX_KEY'), 'base64:'));
        $expectedFirst = hash_hmac('sha256', $normalizedFirst, $hmacKey);
        $expectedLast = hash_hmac('sha256', $normalizedLast, $hmacKey);

        $this->assertEquals($expectedFirst, $rawDbUser->first_name_blind);
        $this->assertEquals($expectedLast, $rawDbUser->last_name_blind);

        $foundFirst = User::findByBlindIndex('first_name', $firstName);
        $foundLast = User::findByBlindIndex('last_name', $lastName);

        $this->assertNotNull($foundFirst);
        $this->assertNotNull($foundLast);
        $this->assertEquals($user->id, $foundFirst->id);
        $this->assertEquals($user->id, $foundLast->id);
    }
}
