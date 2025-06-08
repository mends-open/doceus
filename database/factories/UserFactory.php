<?php

namespace Database\Factories;

use App\Enums\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;
    protected static ?string $fakerLocale = 'pl_PL';

    public function definition(): array
    {
        // Use Language::cases() for random language
        $languages = array_map(fn ($lang) => $lang->value, Language::cases());

        return [
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password', // Will be hashed automatically by your cast
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'pesel' => $this->faker->numerify('###########'), // 11-digit pesel
            'language' => $this->faker->randomElement($languages),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): UserFactory
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }
}
