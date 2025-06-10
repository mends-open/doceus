<?php

use App\Feature\Polymorphic\Enums\MorphType;
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
            $table->id(); // Always first

            $table->enum('type', Arr::pluck(RevisionType::cases(), 'value'));
            $table->enum('revisionable_type', Arr::pluck(MorphType::cases(), 'value'))->index();
            $table->unsignedBigInteger('revisionable_id')->nullable()->index();
            $table->foreignIdFor(Organization::class)
                ->nullable();
            $table->foreignIdFor(User::class)
                ->nullable();
            $table->jsonb('data')->nullable()->index();
            $table->jsonb('meta')->nullable();
            $table->timestamp('dispatched_at', 6);
            $table->timestamp('created_at', 6)->useCurrent();
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
