<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('default_role_id')->nullable()->after('id');
            $table->uuid('default_organization_id')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('default_role_id')->references('id')->on('roles')->nullOnDelete();
            $table->foreign('default_organization_id')->references('id')->on('organizations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['default_role_id']);
            $table->dropColumn('default_role_id');
            $table->dropForeign(['default_organization_id']);
            $table->dropColumn('default_organization_id');
        });
    }
};
