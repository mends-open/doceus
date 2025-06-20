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
            $table->foreignIdFor(Organization::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Location::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Practitioner::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->jsonb('entries');
            $table->unique(['organization_id', 'location_id', 'practitioner_id']);
            $table->timestamps();
            $table->softDeletes();

            $table->index('organization_id');
            $table->index('location_id');
            $table->index('practitioner_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
