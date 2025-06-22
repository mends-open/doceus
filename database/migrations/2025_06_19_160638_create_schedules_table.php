<?php

use App\Models\Location;
use App\Models\Organization;
use App\Models\Practitioner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Practitioner::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Organization::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Location::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->jsonb('entries');
            $table->unique(['practitioner_id', 'location_id']);
            $table->timestamps();
            $table->softDeletes();

            $table->index('practitioner_id');
            $table->index('organization_id');
            $table->index('location_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
