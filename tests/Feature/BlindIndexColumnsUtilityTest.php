<?php

namespace Tests\Feature;

use App\BlindIndex\Database\BlindIndexBlueprint as BlindIndex;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BlindIndexColumnsUtilityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('utility_records', function (Blueprint $table) {
            $table->increments('id');
            BlindIndex::table($table)->columns([
                'secret' => ['unique' => true],
            ]);
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('utility_records');
        parent::tearDown();
    }

    public function test_columns_are_added_using_utility(): void
    {
        $this->assertTrue(Schema::hasColumn('utility_records', 'secret'));
        $this->assertTrue(Schema::hasColumn('utility_records', 'secret_blind'));
    }
}
