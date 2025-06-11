<?php

namespace Database\Factories;

use App\Feature\Identity\Enums\PractitionerQualification as PractitionerQualificationEnum;
use App\Models\Practitioner;
use App\Models\PractitionerQualification as PractitionerQualificationModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PractitionerQualificationFactory extends Factory
{
    // Explicitly specify model class to avoid enum/model naming conflict
    protected $model = PractitionerQualificationModel::class;

    public function definition(): array
    {
        return [
            'practitioner_id' => Practitioner::factory(),
            'qualification' => $this->faker->randomElement(array_map(fn ($q) => $q->value, PractitionerQualificationEnum::cases())),
            'valid_from' => $this->faker->dateTimeBetween('-10 years', '-5 years'),
            'valid_to' => $this->faker->dateTimeBetween('-4 years', 'now'),
        ];
    }
}

