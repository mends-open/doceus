<?php

use App\Feature\Polymorphic\Enums\MorphType;
use App\Models\Patient;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows tagging a patient', function () {
    $patient = Patient::factory()->create();
    $tag = Tag::factory()->create();

    $patient->tags()->sync([$tag->id]);

    $this->assertDatabaseHas('taggables', [
        'tag_id' => $tag->id,
        'taggable_id' => $patient->id,
        'taggable_type' => MorphType::Patient->value,
    ]);
});
