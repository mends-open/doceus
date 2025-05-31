<?php

use App\Database\Views\MaterializedView;
use App\Enums\FeatureEvent;
use App\Enums\OrganizationFeature;
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

        Schema::createMaterializedView('organization_feature', function (MaterializedView $view) {
            $view->query(
                DB::table('organization_feature_events')
                    ->where('event', 'granted')
                    ->distinctOnLatest(['organization_id', 'feature'])
                    ->select([
                        'organization_id',
                        'feature',
                        'event',
                        'created_at',
                    ])
            )->unique(['organization_id', 'feature']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropMaterializedView('organization_feature');
        Schema::dropIfExists('organization_feature_events');
    }
};
