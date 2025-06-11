<?php

namespace Database\Factories;

use App\Models\Person;
use App\Feature\Identity\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'pesel' => $this->faker->numerify('###########'),
            'id_number' => $this->faker->numerify('AA######'),
            'gender' => $this->faker->randomElement(array_map(fn ($g) => $g->value, Gender::cases())),
            'birth_date' => $this->faker->date(),
        ];
    }
}
