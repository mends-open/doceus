<?php

namespace App\Database\BlindIndexes;

use Illuminate\Database\Schema\Blueprint;

/**
 * Utility for managing blind index columns on a table.
 */
class BlindIndex
{
    protected Blueprint $table;

    public static function table(Blueprint $table): static
    {
        $instance = new static;
        $instance->table = $table;

        return $instance;
    }

    /**
     * Add blind index columns using the legacy array syntax.
     */
    public function columns(array $columns): void
    {
        foreach ($columns as $column => $options) {
            $definition = $this->create($column);

            if (is_bool($options) && $options) {
                $definition->unique();
            }

            if (is_array($options)) {
                if (($options['unique'] ?? false) === true) {
                    $definition->unique();
                }

                if (($options['nullable'] ?? false) === true) {
                    $definition->nullable();
                }
            }
        }
    }

    /**
     * Create a new blind index column definition.
     */
    public function create(string $column): BlindIndexColumn
    {
        return new BlindIndexColumn($this->table, $column);
    }
}
