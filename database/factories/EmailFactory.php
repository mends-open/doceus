<?php

namespace Database\Factories;

use App\Models\Email;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    protected $model = Email::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
