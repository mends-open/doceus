<?php

use App\Models\Organization;
use App\Models\Taggable;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class);
            $table->text('name');
            $table->text('description')->nullable();
            $table->enum('color', Arr::pluck(Color::all(), 'key'));
            $table->enum('icon', Arr::pluck(Heroicon::cases(), 'value'));
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
