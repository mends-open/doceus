<?php

use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates location in same organization', function () {
    $schedule = Schedule::factory()->create();

    $organizationId = $schedule->organizations()->first()->id;
    $location = $schedule->locations()->first();

    expect($location->organization_id)->toBe($organizationId);
});

it('attaches practitioner pivot on create', function () {
    $schedule = Schedule::factory()->create();

    expect($schedule->practitioners()->exists())->toBeTrue();
});
