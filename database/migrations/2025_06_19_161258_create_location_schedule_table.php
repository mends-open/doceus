<?php

use App\Models\Location;
use App\Models\Schedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('location_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Schedule::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Location::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['schedule_id', 'location_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('location_schedule');
    }
};
