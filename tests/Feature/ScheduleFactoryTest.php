<?php

use App\Models\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates location in same organization', function () {
    $schedule = Schedule::factory()->create();

    $schedule->refresh();

    expect($schedule->location->organization_id)->toBe($schedule->organization_id);
});

it('enforces one schedule per practitioner per location', function () {
    $first = Schedule::factory()->create();

    expect(fn () => Schedule::factory()->create([
        'practitioner_id' => $first->practitioner_id,
        'organization_id' => $first->organization_id,
        'location_id' => $first->location_id,
    ]))->toThrow(QueryException::class);
});
