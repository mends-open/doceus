<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Organization;
use App\Models\Practitioner;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        $entries = [
            [
                'type' => 'weekly',
                'start_date' => $this->faker->date(),
                'has_end_date' => true,
                'end_date' => $this->faker->date(),
                'start_time' => $this->faker->time('H:i'),
                'end_time' => $this->faker->time('H:i'),
                'days' => [1, 2, 3],
            ],
        ];

        return [
            'practitioner_id' => Practitioner::factory(),
            'organization_id' => Organization::factory(),
            'location_id' => Location::factory(),
            'entries' => $entries,
        ];
    }
}
