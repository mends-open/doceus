<?php

namespace App\Utilities\Postgres\Macros;

use Illuminate\Database\Schema\Blueprint as BlueprintBase;

class Blueprint
{
    /**
     * Register a 'blind' macro:
     * - Adds `{column}` as text (for unencrypted/original)
     * - Adds `{column}_blind` as varchar(64) (for blind index)
     * - Returns the blind index column definition for chaining indexes/etc.
     */
    public static function blind(): void
    {
        BlueprintBase::macro('blind', function ($column, $length = 64) {
            /** @var BlueprintBase $this */
            return $this->char($column.'_blind', $length);
        });
    }
}
