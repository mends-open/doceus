<?php

use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates location in same organization', function () {
    $schedule = Schedule::factory()->create();

    $schedule->refresh();

    expect($schedule->location->organization_id)
        ->toBe($schedule->organization_id);
});
