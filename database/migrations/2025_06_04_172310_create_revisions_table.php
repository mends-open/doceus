<?php

use App\Enums\RevisionType;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at', 6); //we will use timestamp from app level
            $table->foreignIdFor(Organization::class)->nullable()->index();
            $table->foreignIdFor(User::class)->nullable()->index();
            $table->nullableMorphs('revisionable');
            $table->jsonb('data')->index();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisions');
    }
};
