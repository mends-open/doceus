<?php

use App\Models\Patient;
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
        Schema::create('patient_practitioner', function (Blueprint $table) {
            $table->foreignIdFor(Patient::class);
            $table->foreignIdFor(Practitioner::class);

            $table->primary(['patient_id', 'practitioner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_practitioner');
    }
};
