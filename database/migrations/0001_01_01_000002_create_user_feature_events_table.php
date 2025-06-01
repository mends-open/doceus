<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;
use Illuminate\Database\Query\Builder as QueryBuilder;
use App\Enums\UserFeature;
use App\Enums\FeatureEvent;

return new class extends Migration
{
    public function up(): void
    {
        // Add the distinctOn macro to the base query builder for PostgreSQL
        QueryBuilder::macro('distinctOn', function (array $columns) {
            /** @var \Illuminate\Database\Query\Builder $this */
            $grammar = $this->getGrammar();
            $colString = implode(', ', array_map(fn($col) => $grammar->wrap($col), $columns));
            // DISTINCT ON always requires order by same columns + DESC for latest
            $this->selectRaw("DISTINCT ON ({$colString}) *");
            return $this;
        });

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

        // MAIN LOGIC: Use fromSub to get latest event per feature, then filter for granted
        $latestEventSub = DB::table('user_feature_events')
            ->distinctOn(['organization_id', 'user_id', 'feature'])
            ->orderBy('organization_id')
            ->orderBy('user_id')
            ->orderBy('feature')
            ->orderByDesc('created_at');

        Schema::materializedView('user_feature')
            ->query(
                DB::query()
                    ->fromSub($latestEventSub, 'latest_event')
                    ->where('event', FeatureEvent::GRANTED)
                    ->select([
                        'organization_id',
                        'user_id',
                        'feature',
                    ])
            )
            ->unique(['organization_id', 'user_id', 'feature'])
            ->create();

        Schema::materializedView('organization_user')
            ->query(
                DB::table('user_feature_events')
                    ->select(['organization_id', 'user_id'])
                    ->distinct()
            )
            ->unique(['organization_id', 'user_id'])
            ->create();
    }

    public function down(): void
    {
        Schema::dropIfExists('user_feature_events');
        Schema::materializedView('user_feature')->dropIfExists();
        Schema::materializedView('organization_user')->dropIfExists();
    }
};
