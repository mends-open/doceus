<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Practitioner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PractitionerFactory extends Factory
{
    protected $model = Practitioner::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
        ];
    }
}
