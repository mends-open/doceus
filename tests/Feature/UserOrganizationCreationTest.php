<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates practitioner after first login', function () {
    $user = User::factory()->create();

    expect($user->practitioner)->toBeNull();

    event(new \Illuminate\Auth\Events\Login('web', $user, false));

    expect($user->refresh()->practitioner)->not->toBeNull();
    $this->assertDatabaseHas('practitioners', [
        'person_id' => $user->person_id,
    ]);
});

it('attaches practitioner when creating organization from user', function () {
    $user = User::factory()->create();
    event(new \Illuminate\Auth\Events\Login('web', $user, false));
    $attributes = Organization::factory()->make()->toArray();

    $organization = $user->createOrganization($attributes);

    $this->assertDatabaseHas('organization_practitioner', [
        'organization_id' => $organization->id,
        'practitioner_id' => $user->practitioner->id,
    ]);
});
