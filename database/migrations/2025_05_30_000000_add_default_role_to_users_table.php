<?php

use App\Enums\RoleType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('default_role_type', array_column(RoleType::cases(), 'value'))->nullable()->after('pesel');
        });

// Laravel's Blueprint doesn't support composite foreign keys, so use DB::statement:
        DB::statement('
    ALTER TABLE users
    ADD CONSTRAINT users_default_role_fk
    FOREIGN KEY (id, default_role_type)
    REFERENCES roles(user_id, type)
    ON DELETE SET NULL
');
    }

    public function down(): void
    {
// First drop the foreign key, then the column
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_default_role_fk');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('default_role_type');
        });
    }
};
