<?php

use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates location in same organization', function () {
    $schedule = Schedule::factory()->withDefaultAssociations()->create();

    $organizationId = $schedule->organizations()->first()->id;
    $location = $schedule->locations()->first();

    expect($location->organization_id)->toBe($organizationId);
});

it('attaches practitioner pivot on create', function () {
    $schedule = Schedule::factory()->withDefaultAssociations()->create();

    expect($schedule->practitioners()->exists())->toBeTrue();
});

it('attaches location pivot on create', function () {
    $schedule = Schedule::factory()->withDefaultAssociations()->create();

    expect($schedule->locations()->exists())->toBeTrue();
});

it('avoids duplicate pivots when attaching again', function () {
    $schedule = Schedule::factory()->withDefaultAssociations()->create();

    $orgId = $schedule->organizations()->first()->id;
    $practitionerId = $schedule->practitioners()->first()->id;
    $locationId = $schedule->locations()->first()->id;

    // Attach the same pivots a second time
    $schedule->attachOrganization($orgId);
    $schedule->attachPractitioner($practitionerId);
    $schedule->attachLocation($locationId);

    expect($schedule->organizations()->count())->toBe(1)
        ->and($schedule->practitioners()->count())->toBe(1)
        ->and($schedule->locations()->count())->toBe(1);
});
