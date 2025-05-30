<?php

namespace App\Database\BlindIndexes;

use Illuminate\Database\Schema\Blueprint;

class BlindIndex
{
    protected Blueprint $table;

    public static function table(Blueprint $table): static
    {
        $instance = new static();
        $instance->table = $table;

        return $instance;
    }

    /**
     * Add blind index columns to the table.
     */
    public function columns(array $columns): void
    {
        foreach ($columns as $column => $options) {
            $unique = false;
            $nullable = false;

            if (is_bool($options)) {
                $unique = $options;
            } elseif (is_array($options)) {
                $unique = $options['unique'] ?? false;
                $nullable = $options['nullable'] ?? false;
            }

            $textColumn = $this->table->text($column);
            if ($nullable) {
                $textColumn->nullable()->default(null);
            }

            $indexColumn = $this->table->char($column . '_blind_index', 64)->default('');
            if ($nullable) {
                $indexColumn->nullable()->default(null);
            }

            if ($unique) {
                $indexColumn->unique();
            } else {
                $indexColumn->index();
            }
        }
    }
}
