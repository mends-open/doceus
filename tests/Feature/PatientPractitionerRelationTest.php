<?php

use App\Models\Patient;
use App\Models\Practitioner;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('syncs patient and practitioner through pivot', function () {
    $patient = Patient::factory()->create();
    $practitioner = Practitioner::factory()->create();

    $patient->practitioners()->attach($practitioner);

    expect($patient->practitioners->contains($practitioner))->toBeTrue();
    expect($practitioner->patients->contains($patient))->toBeTrue();
});
