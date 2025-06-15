<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Practitioner;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'practitioner_id' => Practitioner::factory(),
            'organization_id' => Organization::factory(),
            'scheduled_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}
