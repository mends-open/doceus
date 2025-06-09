<?php

use App\Models\Email;
use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_person', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Email::class)->index();
            $table->foreignIdFor(Person::class)->index();
            $table->unique(['email_id', 'person_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_person');
    }
};
