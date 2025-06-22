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
            'entries' => $entries,
        ];
    }

    public function withAssociations(?Organization $organization = null, ?Practitioner $practitioner = null, ?Location $location = null): static
    {
        return $this->afterCreating(function (Schedule $schedule) use ($organization, $practitioner, $location) {
            if ($organization) {
                $schedule->organizations()->attach($organization->id);
            }

            if ($practitioner) {
                $schedule->practitioners()->attach($practitioner->id);
            }

            if ($location) {
                $schedule->locations()->attach($location->id);
            }
        });
    }

    public function withDefaultAssociations(): static
    {
        $organization = Organization::factory()->create();

        return $this->withAssociations(
            $organization,
            Practitioner::factory()->create(),
            Location::factory()->for($organization)->create()
        );
    }
}
