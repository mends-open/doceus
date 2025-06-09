<?php

namespace Database\Factories;

use App\Feature\Identity\Enums\ContactPointSystem;
use App\Models\ContactPoint;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactPointFactory extends Factory
{
    protected $model = ContactPoint::class;

    public function definition(): array
    {
        $system = $this->faker->randomElement(ContactPointSystem::cases());

        return [
            'contactable_id' => Person::factory(),
            'contactable_type' => $system->value,
            'value' => $system === ContactPointSystem::Email
                ? $this->faker->unique()->safeEmail
                : $this->faker->phoneNumber,
        ];
    }

    public function email(): static
    {
        return $this->state(fn () => [
            'contactable_type' => ContactPointSystem::Email->value,
            'value' => $this->faker->unique()->safeEmail,
        ]);
    }

    public function phone(): static
    {
        return $this->state(fn () => [
            'contactable_type' => ContactPointSystem::Phone->value,
            'value' => $this->faker->phoneNumber,
        ]);
    }
}
