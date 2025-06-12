<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Feature\Tags\Enums\TagColor;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE tags DROP CONSTRAINT IF EXISTS tags_color_check');
        }

        Schema::table('tags', function (Blueprint $table) {
            $table->string('color')->change();
        });
    }

    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->enum('color', array_column(TagColor::cases(), 'value'))->change();
        });
    }
};
