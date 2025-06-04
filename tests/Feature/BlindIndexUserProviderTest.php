<?php

namespace Tests\Feature;

use App\Models\User;
use App\Traits\Utilities\BlindIndex\Auth\BlindIndexUserProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BlindIndexUserProviderTest extends TestCase
{
    use RefreshDatabase;

    public function test_retrieve_by_credentials_uses_blind_index(): void
    {
        $email = fake()->unique()->safeEmail();
        $user = User::create([
            'email' => $email,
            'password' => Hash::make('password'),
        ]);

        $provider = new BlindIndexUserProvider(app('hash'), User::class);
        $found = $provider->retrieveByCredentials(['email' => $email]);

        $this->assertNotNull($found);
        $this->assertSame($user->id, $found->id);
    }

    public function test_retrieve_by_credentials_returns_null_for_unknown_email(): void
    {
        $provider = new BlindIndexUserProvider(app('hash'), User::class);

        $this->assertNull($provider->retrieveByCredentials(['email' => 'missing@example.com']));
    }
}
