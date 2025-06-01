<?php

namespace App\Utilities\Postgres\Macros;

use Illuminate\Database\Query\Builder as BuilderBase;

/**
 * Provides custom query builder macros for PostgreSQL.
 */
class Builder
{
    /**
     * Registers a 'distinctOn' macro to the base Query Builder for PostgreSQL.
     *
     * Usage:
     *   Model::query()->distinctOn(['col1', 'col2'])->orderBy('col1')->orderBy('col2')->orderByDesc('created_at');
     */
    public static function distinctOn(): void
    {
        BuilderBase::macro('distinctOn', function (array $columns) {
            if (empty($columns)) {
                throw new \InvalidArgumentException('distinctOn requires at least one column.');
            }
            /** @var BuilderBase $this */
            $grammar = $this->getGrammar();
            $wrappedCols = array_map(static fn($col) => $grammar->wrap($col), $columns);
            $colString = implode(', ', $wrappedCols);
            $this->selectRaw("DISTINCT ON ({$colString}) *");
            return $this;
        });
    }
}
