<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns only practitioner organizations', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $practitioner1 = \App\Models\Practitioner::factory()->for($user->person)->create();
    $practitioner2 = \App\Models\Practitioner::factory()->for($other->person)->create();

    $org1 = Organization::factory()->create();
    $org2 = Organization::factory()->create();

    $practitioner1->organizations()->attach($org1);
    $practitioner2->organizations()->attach($org2);

    expect($user->organizations->contains($org1))->toBeTrue();
    expect($user->organizations->contains($org2))->toBeFalse();
});
