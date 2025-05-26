<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPeselUniqueTest extends TestCase
{
    use RefreshDatabase;

    public function test_allows_multiple_users_with_null_pesel(): void
    {
        User::create([
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        User::create([
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $this->assertDatabaseCount('users', 2);
    }

    public function test_duplicate_pesel_is_invalid(): void
    {
        $pesel = '44051401359';

        User::create([
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'pesel' => $pesel,
        ]);

        $this->expectException(QueryException::class);

        User::create([
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'pesel' => $pesel,
        ]);
    }
}
