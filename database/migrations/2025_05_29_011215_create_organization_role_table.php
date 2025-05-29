<?php

use App\Enums\RoleType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organization_role', function (Blueprint $table) {
            $table->uuid('organization_id');
            $table->uuid('user_id');
            $table->enum('role_type', array_column(RoleType::cases(), 'value'));
            $table->timestamps();

            // Composite foreign key
            $table->foreign(['user_id', 'role_type'])
                ->references(['user_id', 'type'])
                ->on('roles')
                ->onDelete('cascade');

            // Foreign key for organization
            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_role');
    }
};
