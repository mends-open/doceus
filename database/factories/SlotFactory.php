<?php

namespace Database\Factories;

use App\Feature\Scheduling\Enums\SlotStatus;
use App\Models\Schedule;
use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class SlotFactory extends Factory
{
    protected $model = Slot::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+0 days', '+1 week');
        $end = (clone $start)->modify('+30 minutes');

        return [
            'schedule_id' => Schedule::factory(),
            'start_at' => $start,
            'end_at' => $end,
            'status' => Arr::random(SlotStatus::cases())->value,
        ];
    }
}
