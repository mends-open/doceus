<?php

namespace Tests\Feature;

use App\Feature\Tags\Enums\TagColor;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagColorTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_color_casts_to_enum(): void
    {
        $tag = Tag::factory()->create(['color' => TagColor::Blue->value]);

        $this->assertInstanceOf(TagColor::class, $tag->color);
        $this->assertSame(TagColor::Blue, $tag->color);
    }
}
