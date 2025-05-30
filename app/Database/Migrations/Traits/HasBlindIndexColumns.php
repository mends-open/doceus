<?php

namespace App\Database\Migrations\Traits;

use App\Database\BlindIndexes\BlindIndex;
use Illuminate\Database\Schema\Blueprint;

trait HasBlindIndexColumns
{
    protected function addBlindIndexColumns(Blueprint $table, array $columns): void
    {
        BlindIndex::table($table)->columns($columns);
    }
}
