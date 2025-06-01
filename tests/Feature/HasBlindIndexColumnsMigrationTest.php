<?php

namespace Tests\Feature;

use App\Utilities\BlindIndex\Traits\HasBlindIndexColumns;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HasBlindIndexColumnsMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $migration = new class
        {
            use HasBlindIndexColumns;

            public function build(Blueprint $table): void
            {
                $this->addBlindIndexColumns($table, [
                    'secret' => ['unique' => true],
                    'note' => ['nullable' => true],
                ]);
            }
        };

        Schema::create('temp_records', function (Blueprint $table) use ($migration) {
            $table->increments('id');
            $migration->build($table);
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('temp_records');
        parent::tearDown();
    }

    public function test_columns_and_constraints_are_applied(): void
    {
        $this->assertTrue(Schema::hasColumn('temp_records', 'secret'));
        $this->assertTrue(Schema::hasColumn('temp_records', 'secret_blind_index'));
        $this->assertTrue(Schema::hasColumn('temp_records', 'note'));
        $this->assertTrue(Schema::hasColumn('temp_records', 'note_blind_index'));

        DB::table('temp_records')->insert([
            'secret' => 'abc',
            'note' => null,
        ]);

        $this->expectException(QueryException::class);

        DB::table('temp_records')->insert([
            'secret' => 'abc',
            'note' => null,
        ]);
    }
}
