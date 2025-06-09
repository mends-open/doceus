<?php

namespace Database\Factories;

use App\Feature\Identity\Enums\OrganizationType;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        $types = array_map(fn ($type) => $type->value, OrganizationType::cases());

        return [
            'type' => $this->faker->randomElement($types),
            'name' => $this->faker->company,
        ];
    }
}
