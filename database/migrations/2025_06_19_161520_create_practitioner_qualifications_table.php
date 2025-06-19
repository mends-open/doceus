<?php

use App\Feature\Identity\Enums\PractitionerQualification as PractitionerQualificationEnum;
use App\Models\Practitioner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('practitioner_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Practitioner::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('qualification', array_column(PractitionerQualificationEnum::cases(), 'value'));
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('practitioner_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practitioner_qualifications');
    }
};
