<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('links practitioner to user via person', function () {
    $user = User::factory()->create();

    expect($user->practitioner)->toBeNull();

    $practitioner = \App\Models\Practitioner::factory()
        ->for($user->person)
        ->create();

    expect($user->refresh()->practitioner->is($practitioner))->toBeTrue();
});

it('attaches practitioner when creating organization from user', function () {
    $user = User::factory()->create();
    $practitioner = \App\Models\Practitioner::factory()
        ->for($user->person)
        ->create();
    $attributes = Organization::factory()->make()->toArray();

    $organization = $user->createOrganization($attributes);

    $this->assertDatabaseHas('organization_practitioner', [
        'organization_id' => $organization->id,
        'practitioner_id' => $practitioner->id,
    ]);
});
