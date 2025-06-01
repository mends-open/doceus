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

        Schema::createMaterializedView('organization_feature', DB::query()
            ->fromSub(
                DB::table('organization_feature_events')
                    ->distinctOn(['organization_id', 'feature'])
                    ->orderBy('organization_id')
                    ->orderBy('feature')
                    ->orderByDesc('created_at'), 'latest_event')
            ->where('event', FeatureEvent::GRANTED)
            ->select([
                'organization_id',
                'feature',
            ])
        );
    }

    public function down(): void
    {
        Schema::dropMaterializedView('organization_feature');
        Schema::dropIfExists('organization_feature_events');
    }
};
