<?php

use App\Models\Patient;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_tag', function (Blueprint $table) {
            $table->foreignIdFor(Patient::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Tag::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['patient_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_tag');
    }
};
