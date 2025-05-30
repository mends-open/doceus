<?php

use App\Enums\FeatureEvent;
use App\Enums\UserFeature;
use App\Database\Views\MaterializedView;
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
        Schema::create('organization_user_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('user_id');
            $table->enum('user_feature', Arr::pluck(UserFeature::cases(), 'value'));
            $table->enum('event', Arr::pluck(FeatureEvent::cases(), 'value'));
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::createMaterializedView('organization_user_feature', function (MaterializedView $view) {
            $view->query(<<<SQL
SELECT organization_id, user_id, user_feature
FROM (
    SELECT organization_id,
           user_id,
           user_feature,
           event,
           created_at,
           ROW_NUMBER() OVER (PARTITION BY organization_id, user_id, user_feature ORDER BY created_at DESC) AS rn
    FROM organization_user_events
) t
WHERE rn = 1 AND event = 'granted'
SQL);

            $view->unique(['organization_id', 'user_id', 'user_feature']);
        });

        Schema::createMaterializedView('organization_user', function (MaterializedView $view) {
            $view
                ->select('organization_id', 'user_id')
                ->distinct()
                ->from('organization_user_events')
                ->unique(['organization_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropMaterializedView('organization_user');
        Schema::dropMaterializedView('organization_user_feature');
        Schema::dropIfExists('organization_user_events');
    }
};
