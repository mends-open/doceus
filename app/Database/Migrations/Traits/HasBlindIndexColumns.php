<?php

namespace App\Database\Migrations\Traits;

use App\BlindIndex\Database\BlindIndexBlueprint;
use Illuminate\Database\Schema\Blueprint;

trait HasBlindIndexColumns
{
    protected function addBlindIndexColumns(Blueprint $table, array $columns): void
    {
        BlindIndexBlueprint::table($table)->columns($columns);
    }
}
