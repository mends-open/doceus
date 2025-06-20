<?php

namespace Database\Factories;

use App\Feature\Scheduling\Enums\RepeatPattern;
use App\Feature\Scheduling\Enums\ScheduleType;
use App\Models\Organization;
use App\Models\Practitioner;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        $repeat = Arr::random(RepeatPattern::cases());
        $type = Arr::random(ScheduleType::cases());

        return [
            'practitioner_id' => Practitioner::factory(),
            'organization_id' => Organization::factory(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'days_of_week' => [1, 2, 3],
            'repeat_pattern' => $repeat->value,
            'type' => $type->value,
        ];
    }
}
