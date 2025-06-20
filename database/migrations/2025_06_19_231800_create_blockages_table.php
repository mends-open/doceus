<?php

use App\Models\Schedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blockages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Schedule::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('schedule_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blockages');
    }
};
