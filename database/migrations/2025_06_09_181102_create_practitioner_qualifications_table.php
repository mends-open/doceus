<?php

use App\Feature\Identity\Enums\PrectitionerQualification;
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
        Schema::create('practitioner_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Practitioner::class);
            $table->enum('qualification', Arr::pluck(PrectitionerQualification::cases(), 'value'));
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practitioner_qualifications');
    }
};
