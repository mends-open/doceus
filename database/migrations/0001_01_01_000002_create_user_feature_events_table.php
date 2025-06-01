<?php

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
        Schema::create('user_feature_events', function (Blueprint $table) {
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

        // Materialized views remain as before...
        Schema::createMaterializedView('user_feature', DB::query()
            ->fromSub(
                DB::table('user_feature_events')
                    ->distinctOn(['organization_id', 'user_id', 'feature'])
                    ->orderBy('organization_id')
                    ->orderBy('user_id')
                    ->orderBy('feature')
                    ->orderByDesc('created_at'), 'latest_event')
            ->where('event', FeatureEvent::GRANTED)
            ->select([
                'organization_id',
                'user_id',
                'feature',
            ])
        );

        DB::statement('create unique index user_feature_idx on user_feature (organization_id, user_id, feature)');

        Schema::createMaterializedView('organization_user',
            DB::table('user_feature_events')
                ->select(['organization_id', 'user_id'])
                ->distinct());

        DB::statement('create unique index organization_user_idx on organization_user (organization_id, user_id)');

        // --- REFRESH FUNCTION ---
        DB::statement(<<<'SQL'
        CREATE OR REPLACE FUNCTION refresh_user_feature_mv()
        RETURNS trigger AS $$
        BEGIN
            REFRESH MATERIALIZED VIEW CONCURRENTLY user_feature;
            REFRESH MATERIALIZED VIEW CONCURRENTLY organization_user;
            RETURN NULL;
        END;
        $$ LANGUAGE plpgsql;
    SQL);

        // --- INSERT TRIGGER ---
        DB::statement('DROP TRIGGER IF EXISTS trg_refresh_user_feature_mv ON user_feature_events;');
DB::statement(<<<'SQL'
    CREATE TRIGGER trg_refresh_user_feature_mv
    AFTER INSERT OR UPDATE OR DELETE
    ON user_feature_events
    FOR EACH STATEMENT
    EXECUTE FUNCTION refresh_user_feature_mv();
SQL);
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS trg_refresh_user_feature_mv ON user_feature_events;');
        DB::statement('DROP FUNCTION IF EXISTS refresh_user_feature_mv();');

        Schema::dropMaterializedView('user_feature');
        Schema::dropMaterializedView('organization_user');
        Schema::dropIfExists('user_feature_events');
    }
};
