<?php

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\IdentityType;
use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->binary('first_name')->nullable();
            $table->binary('last_name')->nullable();
            $table->binary('pesel')->nullable();
            $table->binary('identity_number')->nullable();
            $table->enum('identity_type', [
                Arr::pluck(IdentityType::cases(), 'value')
            ])->nullable();
            $table->enum('gender', [
                Arr::pluck(Gender::cases(), 'value')
            ])->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Person::class)
                ->after('id')
                ->nullable()
                ->constrained();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
            $table->dropColumn('person_id');
        });
        Schema::dropIfExists('people');
    }
};
