<?php

use App\Database\Views\MaterializedView;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        MaterializedView::make('organization_user')
            ->query(
                DB::table('organization_user_features')
                    ->selectRaw('DISTINCT organization_id, user_id')
            )
            ->uniqueIndex('organization_user_pk', ['organization_id', 'user_id'])
            ->create();
    }

    public function down(): void
    {
        MaterializedView::make('organization_user')->drop();
    }
};
