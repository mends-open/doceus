<?php

use App\Feature\Identity\Enums\Gender;
use App\Models\Person;
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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->text('first_name');
            $table->text('last_name');
            $table->text('pesel')->nullable();
            $table->text('id_number')->nullable();
            $table->enum('gender', Arr::pluck(Gender::cases(), 'value'))->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Person::class)->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignIdFor(Person::class);
        });
    }
};
