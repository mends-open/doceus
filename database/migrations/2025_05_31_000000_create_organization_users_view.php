<?php

use App\Support\MaterializedView;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        MaterializedView::create('organization_users', '
            SELECT DISTINCT organization_id, user_id
            FROM organization_user_features
        ');

        DB::statement('CREATE UNIQUE INDEX organization_users_pk ON organization_users (organization_id, user_id)');
    }

    public function down(): void
    {
        MaterializedView::drop('organization_users');
    }
};
