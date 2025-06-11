<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_points', function (Blueprint $table) {
            $table->unique(['contactable_id', 'contactable_type', 'system', 'value'], 'contact_points_unique');
        });
    }

    public function down(): void
    {
        Schema::table('contact_points', function (Blueprint $table) {
            $table->dropUnique('contact_points_unique');
        });
    }
};
