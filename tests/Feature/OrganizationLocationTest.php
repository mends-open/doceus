<?php

use App\Feature\Identity\Enums\LocationType;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates default virtual location for new organization', function () {
    $organization = Organization::factory()->create();

    $organization->refresh();

    expect($organization->locations)->toHaveCount(1)
        ->and($organization->locations->first()->type)->toBe(LocationType::Virtual)
        ->and($organization->locations->first()->name)->toBeNull();
});
