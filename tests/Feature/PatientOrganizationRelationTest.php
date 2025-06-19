<?php

use App\Models\Organization;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns only organizations attached to patient', function () {
    $patient = Patient::factory()->create();
    $org1 = Organization::factory()->create();
    $org2 = Organization::factory()->create();

    $patient->organizations()->attach($org1);

    expect($patient->organizations->contains($org1))->toBeTrue();
    expect($patient->organizations->contains($org2))->toBeFalse();
});
