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

        $organization = Organization::factory()->create();
        $practitioner = Practitioner::factory()->create();
        $location = Location::factory()->for($organization)->create();

        return [
            'schedulable_type' => Practitioner::class,
            'schedulable_id' => $practitioner->id,
            'location_id' => $location->id,
            'entries' => $entries,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Schedule $schedule) {
            $organizationId = $schedule->location->organization_id;
            $schedule->organizations()->attach($organizationId);
            if ($schedule->schedulable_type === Practitioner::class) {
                $schedule->practitioners()->attach($schedule->schedulable_id);
            }
        });
    }
}
