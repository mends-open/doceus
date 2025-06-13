<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates practitioner when user is created', function () {
    $user = User::factory()->create();

    expect($user->practitioner)->not->toBeNull();
    $this->assertDatabaseHas('practitioners', [
        'person_id' => $user->person_id,
    ]);
});

it('attaches practitioner when creating organization from user', function () {
    $user = User::factory()->create();
    $attributes = Organization::factory()->make()->toArray();

    $organization = $user->createOrganization($attributes);

    $this->assertDatabaseHas('organization_practitioner', [
        'organization_id' => $organization->id,
        'practitioner_id' => $user->practitioner->id,
    ]);
});
