<?php

use App\Enums\FeatureEvent;
use App\Enums\OrganizationFeature;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_feature_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->enum('feature', Arr::pluck(OrganizationFeature::cases(), 'value'));
            $table->enum('event', Arr::pluck(FeatureEvent::cases(), 'value'));
            $table->timestamp('created_at')->useCurrent();
            $table->uuid('created_by');

            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });

        Schema::materializedView('organization_feature')
            ->query(
                DB::table('organization_feature_events')
                    ->where('event', 'granted')
                    ->distinctOnLatest(['organization_id', 'feature'])
                    ->select([
                        'organization_id',
                        'feature',
                    ])
            )
            ->unique(['organization_id', 'feature'])
            ->create();
    }

    public function down(): void
    {
        Schema::materializedView('organization_feature')->dropIfExists();
        Schema::dropIfExists('organization_feature_events');
    }
};
