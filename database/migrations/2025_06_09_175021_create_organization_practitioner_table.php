<?php

use App\Models\Organization;
use App\Models\Practitioner;
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
        Schema::create('organization_practitioner', function (Blueprint $table) {
            $table->foreignIdFor(Organization::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Practitioner::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['organization_id', 'practitioner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_practitioner');
    }
};
