<?php

use App\Database\Migrations\Traits\HasBlindIndexColumns;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
                'email' => ['unique' => true],
                'first_name' => ['nullable' => true],
                'last_name' => ['nullable' => true],
                'pesel' => ['unique' => true, 'nullable' => true],
            ]);

            $table->enum('language', ['en', 'pl'])->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
