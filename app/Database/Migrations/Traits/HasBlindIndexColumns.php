<?php

namespace App\Database\Migrations\Traits;

use Illuminate\Database\Schema\Blueprint;

trait HasBlindIndexColumns
{
    protected function addBlindIndexColumns(Blueprint $table, array $columns): void
    {
        \App\Database\BlindIndex::addColumns($table, $columns);
    }
}
