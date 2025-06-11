<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Organization;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $colors = array_keys(Color::all());
        $icons = array_map(fn (Heroicon $icon) => $icon->value, Heroicon::cases());

        return [
            'organization_id' => Organization::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'color' => $this->faker->randomElement($colors),
            // Store the icon value so casts can rehydrate the enum
            'icon' => $this->faker->randomElement($icons),
        ];
    }
}
