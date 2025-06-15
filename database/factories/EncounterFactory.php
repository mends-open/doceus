<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Encounter;
use Illuminate\Database\Eloquent\Factories\Factory;

class EncounterFactory extends Factory
{
    protected $model = Encounter::class;

    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::factory(),
            'notes' => $this->faker->sentence,
        ];
    }
}
