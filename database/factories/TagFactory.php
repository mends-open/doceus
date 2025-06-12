<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Organization;
use App\Feature\Tags\Enums\TagColor;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $colors = array_column(TagColor::cases(), 'value');

        return [
            'organization_id' => Organization::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'color' => $this->faker->randomElement($colors),
        ];
    }
}
