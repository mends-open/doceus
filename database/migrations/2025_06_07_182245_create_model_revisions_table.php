<?php

use App\Enums\Revisions\ModelRevisionType;
use App\Models\Organization;
use App\Models\User;
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
        Schema::create('model_revisions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('dispatched_at', 6); // we will use timestamp from app level
            $table->timestamp('created_at', 6)->useCurrent();
            $table->foreignIdFor(Organization::class)->nullable()->index();
            $table->foreignIdFor(User::class)->nullable()->index();
            $table->nullableMorphs('revisionable');
            $table->enum('type', Arr::pluck(ModelRevisionType::cases(), 'value'));
            $table->jsonb('data')->index();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_revisions');
    }
};
