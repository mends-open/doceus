<?php

namespace App\Utilities\Postgres\Macros;

use Illuminate\Support\Facades\Schema as BaseSchema;
use App\Utilities\MaterializedView\MaterializedView;
use Illuminate\Support\Facades\DB;

class Schema
{
    /**
     * Register the macro for creating a materialized view.
     */
    public static function materializedView(): void
    {
        BaseSchema::macro('materializedView', function (string $name) {
            return new MaterializedView($name);
        });
    }

    /**
     * Register the macro for dropping a materialized view if it exists.
     */
    public static function dropMaterializedView(): void
    {
        BaseSchema::macro('dropMaterializedView', function (string $name): void {
            DB::statement(sprintf(
                'DROP MATERIALIZED VIEW IF EXISTS %s CASCADE',
                DB::getSchemaGrammar()->wrapTable($name)
            ));
        });
    }
}
