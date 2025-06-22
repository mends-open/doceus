<?php

use App\Models\Practitioner;
use App\Models\Schedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('practitioner_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Schedule::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Practitioner::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['schedule_id', 'practitioner_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practitioner_schedule');
    }
};
