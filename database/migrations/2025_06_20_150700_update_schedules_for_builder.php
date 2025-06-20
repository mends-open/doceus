<?php

use App\Models\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn([
                'start_date',
                'start_time',
                'end_time',
                'repeat_until',
                'days_of_week',
                'repeat_pattern',
                'is_blocking',
            ]);
            $table->foreignIdFor(Location::class)
                ->after('organization_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();
            $table->jsonb('entries');
            $table->unique(['practitioner_id', 'location_id']);
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropUnique(['practitioner_id', 'location_id']);
            $table->dropColumn('entries');
            $table->dropConstrainedForeignId('location_id');
            $table->date('start_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('repeat_until')->nullable();
            $table->json('days_of_week')->nullable();
            $table->enum('repeat_pattern', ['none', 'weekly'])->default('weekly');
            $table->boolean('is_blocking')->default(false);
        });
    }
};
