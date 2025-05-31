<?php

use App\Database\Views\MaterializedView;
use App\Enums\FeatureEvent;
use App\Enums\UserFeature;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_user_feature_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('user_id');
            $table->enum('feature', Arr::pluck(UserFeature::cases(), 'value'));
            $table->enum('event', Arr::pluck(FeatureEvent::cases(), 'value'));
            $table->timestamp('created_at')->useCurrent();
            $table->uuid('created_by');

            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });

        // organization_user_feature view using the optimized MaterializedView approach
        Schema::materializedView('organization_user_feature')
            ->query(
                DB::table(DB::raw('(
                    SELECT DISTINCT ON (organization_id, user_id, feature)
                        organization_id,
                        user_id,
                        feature,
                        event
                    FROM organization_user_feature_events
                    ORDER BY organization_id, user_id, feature, created_at DESC
                ) as last_event'))
                ->where('event', 'granted')
                ->select(['organization_id', 'user_id', 'feature'])
            )
            ->unique(['organization_id', 'user_id', 'feature'])
            ->create();

        // organization_user view using the optimized approach
        Schema::materializedView('organization_user')
            ->query(
                DB::table('organization_user_feature_events')
                    ->select(['organization_id', 'user_id'])
                    ->distinct()
            )
            ->unique(['organization_id', 'user_id'])
            ->create();
    }

    public function down(): void
    {
        Schema::materializedView('organization_user_role')->dropIfExists();
        Schema::materializedView('organization_user')->dropIfExists();
        Schema::dropIfExists('organization_user_feature_events');
    }
};
