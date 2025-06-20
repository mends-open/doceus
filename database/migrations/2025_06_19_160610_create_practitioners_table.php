<?php

use App\Feature\Identity\Enums\Language;
use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('practitioners', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Person::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->text('email');
            $table->text('phone_number')->nullable();
            $table->enum('language', Arr::pluck(Language::cases(), 'value'))->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->jsonb('qualifications')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('person_id');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practitioners');
    }
};
