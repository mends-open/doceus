<?php

use App\Database\Migrations\Traits\HasBlindIndexColumns;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    use HasBlindIndexColumns;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personnel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('unit_id')->constrained('units', 'id');
            $table->foreignUuid('user_id')->constrained('users', 'id');

            $this->addBlindIndexColumns($table, [
                'name' => ['nullable' => false],
            ]);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel');
    }
};
