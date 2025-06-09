<?php

use App\Models\Phone;
use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('person_phone', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Person::class)->index();
            $table->foreignIdFor(Phone::class)->index();
            $table->unique(['person_id', 'phone_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_phone');
    }
};
