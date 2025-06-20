<?php

use App\Feature\Identity\Enums\LocationType;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('defaults type to virtual when not provided', function () {
    $attributes = Location::factory()->raw();
    unset($attributes['type']);

    $location = Location::create($attributes);
    $location->refresh();

    expect($location->type)->toBe(LocationType::Virtual);
});

it('allows name to be null', function () {
    $location = Location::factory()->create(['name' => null]);

    expect($location->name)->toBeNull();
});
