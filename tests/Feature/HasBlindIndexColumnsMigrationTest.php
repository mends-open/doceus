<?php

namespace Tests\Feature;

use App\Database\Migrations\Traits\HasBlindIndexColumns;
use App\Models\Traits\HasBlindIndex;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HasBlindIndexColumnsMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('temp_records', function (Blueprint $table) {
            $table->id();

            // Use the trait via an anonymous helper
            (new class {
                use HasBlindIndexColumns;
                public function handle(Blueprint $table): void
                {
                    $this->addBlindIndexColumns($table, [
                        'secret' => true,
                        'note' => ['nullable' => true],
                    ]);
                }
            })->handle($table);

            $table->timestamps();
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

        $record = TempRecord::create([
            'secret' => 'abc',
            'note' => 'first',
        ]);

        $this->assertDatabaseHas('temp_records', ['id' => $record->id]);

        $this->expectException(QueryException::class);

        TempRecord::create([
            'secret' => 'abc',
            'note' => 'second',
        ]);
    }
}

class TempRecord extends Model
{
    use HasBlindIndex;

    protected $table = 'temp_records';
    protected $fillable = ['secret', 'note'];

    protected $blind = [
        'secret' => ['unique' => true],
        'note' => ['nullable' => true],
    ];
}