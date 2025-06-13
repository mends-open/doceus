<?php

use App\Feature\Tags\Enums\TagColor;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('casts color to enum', function () {
    $tag = Tag::factory()->create(['color' => TagColor::Primary->value]);

    expect($tag->color)->toBeInstanceOf(TagColor::class)
        ->and($tag->color)->toBe(TagColor::Primary);
});
