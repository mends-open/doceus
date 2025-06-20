<?php

use App\Feature\Scheduling\Enums\RepeatPattern;
use App\Models\Practitioner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
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
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->json('days_of_week');
            $table->enum('repeat_pattern', Arr::pluck(RepeatPattern::cases(), 'value'))
                ->default(RepeatPattern::Weekly->value);
            $table->timestamps();
            $table->softDeletes();

            $table->index('practitioner_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
