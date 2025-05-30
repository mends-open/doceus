<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BlindIndexBlueprintMacroTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('macro_records', function (Blueprint $table) {
            $table->increments('id');
            $table->blindIndex('secret')->unique();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('macro_records');
        parent::tearDown();
    }

    public function test_macro_creates_columns(): void
    {
        $this->assertTrue(Schema::hasColumn('macro_records', 'secret'));
        $this->assertTrue(Schema::hasColumn('macro_records', 'secret_blind_index'));
    }
}
