<?php

namespace Tests\Feature;

use App\Feature\Polymorphic\Enums\MorphType;
use App\Models\Patient;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTagsTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_be_tagged(): void
    {
        $patient = Patient::factory()->create();
        $tag = Tag::factory()->create();

        $patient->tags()->sync([$tag->id]);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $patient->id,
            'taggable_type' => MorphType::Patient->value,
        ]);
    }
}
