<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Database\Migrations\Traits\HasBlindIndexColumns;
use App\Database\Migrations\Enums\BlindIndexType;

return new class extends Migration
{
    use HasBlindIndexColumns;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();

          $this->addBlindIndexColumns($table, [
                'email' => BlindIndexType::NOT_NULL_UNIQUE,
                'first_name' => BlindIndexType::NULLABLE,
                'last_name' => BlindIndexType::NULLABLE,
                'pesel' => BlindIndexType::NULLABLE_UNIQUE,
            ]);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email'); // unencrypted
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
