<?php

use App\Models\Patient;
use App\Models\Practitioner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_practitioner', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Patient::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Practitioner::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['patient_id', 'practitioner_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_practitioner');
    }
};
