<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Person;
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
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'birth_date' => $this->faker->date(),
            'organization_id' => Organization::factory(),
        ];
    }
}
