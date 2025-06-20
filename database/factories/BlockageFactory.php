<?php

namespace Database\Factories;

use App\Models\Blockage;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlockageFactory extends Factory
{
    protected $model = Blockage::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+0 days', '+1 week');
        $end = (clone $start)->modify('+1 hour');

        return [
            'schedule_id' => Schedule::factory(),
            'start_at' => $start,
            'end_at' => $end,
            'reason' => $this->faker->sentence,
        ];
    }
}
