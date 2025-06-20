<?php

use App\Models\Schedule;
use App\Models\Slot;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates slots for a schedule', function () {
    $schedule = Schedule::factory()->create();
    $slot = Slot::factory()->create([
        'schedule_id' => $schedule->id,
    ]);

    $schedule->refresh();

    expect($schedule->slots->contains($slot))->toBeTrue();
});
