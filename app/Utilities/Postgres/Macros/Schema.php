<?php

namespace App\Utilities\Postgres\Macros;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema as BaseSchema;

class Schema
{
    public static function createMaterializedView(): void
    {
        BaseSchema::macro('createMaterializedView', function (string $name, Builder $query) {
            Schema::runCreateViewMacro('materialized view', $name, $query);
        });
    }

    public static function createView(): void
    {
        BaseSchema::macro('createView', function (string $name, Builder $query) {
            Schema::runCreateViewMacro('view', $name, $query);
        });
    }

    public static function dropMaterializedView(): void
    {
        BaseSchema::macro('dropMaterializedView', function (string $name): void {
            Schema::runDropViewMacro('materialized view', $name);
        });
    }

    public static function dropView(): void
    {
        BaseSchema::macro('dropView', function (string $name): void {
            Schema::runDropViewMacro('view', $name);
        });
    }

    /**
     * Shared logic for creating a view or materialized view.
     */
    private static function runCreateViewMacro(string $type, string $name, Builder $query): void
    {
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        foreach ($bindings as $binding) {
            $value = is_numeric($binding)
                ? $binding
                : "'" . str_replace("'", "''", $binding) . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }

        DB::statement(sprintf(
            'create %s %s as %s',
            $type,
            DB::getSchemaGrammar()->wrapTable($name),
            $sql
        ));
    }

    /**
     * Shared logic for dropping a view or materialized view.
     */
    private static function runDropViewMacro(string $type, string $name): void
    {
        DB::statement(sprintf(
            'drop %s if exists %s cascade',
            $type,
            DB::getSchemaGrammar()->wrapTable($name)
        ));
    }
}
