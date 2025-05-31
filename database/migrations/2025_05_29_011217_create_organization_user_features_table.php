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
    /**
     * Run the migrations.
     */
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

        Schema::createMaterializedView('organization_user_feature', function (MaterializedView $view) {
            $view->query(
                DB::table('organization_user_feature_events')
                    ->distinctOnLatest(['organization_id', 'user_id', 'feature'])
                    ->where('event', 'granted')
                    ->select([
                        'organization_id',
                        'user_id',
                        'feature',
                    ])
            )->unique(['organization_id', 'user_id', 'feature']); // Add or adjust indexes as needed
        });

        // organization_user view: pure builder
        Schema::createMaterializedView('organization_user', function (MaterializedView $view) {
            $view->query(
                DB::table('organization_user_feature_events')
                    ->select(['organization_id', 'user_id'])
                    ->distinct()
            )->unique(['organization_id', 'user_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropMaterializedView('organization_user_role');
        Schema::dropMaterializedView('organization_user');
        Schema::dropIfExists('organization_user_events');
    }
};
