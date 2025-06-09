<?php

use App\Feature\Identity\Enums\ContactableType;
use App\Feature\Identity\Enums\ContactPointSystem;
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
        Schema::create('contact_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contactable_id');
            $table->enum('contactable_type', Arr::pluck(ContactableType::cases(), 'value'));
            $table->enum('system', Arr::pluck(ContactPointSystem::cases(), 'value'));
            $table->text('value');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_points');
    }
};
