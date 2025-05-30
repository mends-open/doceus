<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class MaterializedView
{
    public static function create(string $name, string $query): void
    {
        DB::statement("CREATE MATERIALIZED VIEW {$name} AS {$query}");
    }

    public static function drop(string $name): void
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS {$name} CASCADE");
    }

    public static function refresh(string $name, bool $concurrently = false): void
    {
        $concurrent = $concurrently ? 'CONCURRENTLY ' : '';
        DB::statement("REFRESH MATERIALIZED VIEW {$concurrent}{$name}");
    }
}
