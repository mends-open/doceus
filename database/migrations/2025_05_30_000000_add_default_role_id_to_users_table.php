<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('default_role_id')->nullable()->after('pesel');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('default_role_id')->references('id')->on('roles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['default_role_id']);
            $table->dropColumn('default_role_id');
        });
    }
};
