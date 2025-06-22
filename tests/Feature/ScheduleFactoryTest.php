<?php

use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates location in same organization', function () {
    $schedule = Schedule::factory()->create();

    $location = $schedule->locations->first();
    $organization = $schedule->organizations->first();

    expect($location->organization_id)->toBe($organization->id);
});
