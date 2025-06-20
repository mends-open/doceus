<?php

namespace Database\Factories;

use App\Feature\Identity\Enums\Language;
use App\Models\Person;
use App\Models\Practitioner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PractitionerFactory extends Factory
{
    protected $model = Practitioner::class;

    public function definition(): array
    {
        $languages = array_map(fn ($lang) => $lang->value, Language::cases());

        return [
            'person_id' => Person::factory(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'language' => $this->faker->randomElement($languages),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): PractitionerFactory
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }

    public function withoutPerson(): PractitionerFactory
    {
        return $this->state(fn () => [
            'person_id' => null,
        ]);
    }
}
