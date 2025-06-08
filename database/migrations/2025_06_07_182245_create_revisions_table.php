<?php

use App\Feature\MorphClass\Enums\MorphClass;
use App\Feature\Revision\Enums\RevisionType;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('dispatched_at', 6); // app-level timestamp
            $table->timestamp('created_at', 6)->useCurrent();
            $table->foreignIdFor(Organization::class)->nullable()->index();
            $table->foreignIdFor(User::class)->nullable()->index();
            $table->unsignedBigInteger('revisionable_id')->nullable()->index();
            $table->enum('revisionable_type', Arr::pluck(MorphClass::cases(), 'value'))->index();
            $table->enum('type', Arr::pluck(RevisionType::cases(), 'value'));
            $table->jsonb('data')->index()->nullable();
            $table->jsonb('meta')->nullable();
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url', 2048)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revisions');
    }
};
