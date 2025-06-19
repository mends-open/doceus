<?php

namespace Database\Factories;

use App\Feature\Identity\Enums\LocationType;
use App\Models\Location;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        $types = array_map(fn ($type) => $type->value, LocationType::cases());

        return [
            'organization_id' => Organization::factory(),
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement($types),
            'address' => ['line' => [$this->faker->streetAddress]],
            'description' => $this->faker->sentence,
        ];
    }

}
