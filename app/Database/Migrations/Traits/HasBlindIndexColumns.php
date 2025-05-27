<?php

namespace App\Database\Migrations\Traits;

use Illuminate\Database\Schema\Blueprint;

trait HasBlindIndexColumns
{
    protected function addBlindIndexColumns(Blueprint $table, array $fields): void
    {
        foreach ($fields as $field => $options) {
            $unique = false;
            $nullable = false;

            if (is_bool($options)) {
                $unique = $options;
            } elseif (is_array($options)) {
                $unique = $options['unique'] ?? false;
                $nullable = $options['nullable'] ?? false;
            }

            $textColumn = $table->text($field);
            if ($nullable) {
                $textColumn->nullable();
            }

            $indexColumn = $table->char($field . '_blind_index', 64);
            if ($nullable) {
                $indexColumn->nullable();
            } else {
                $indexColumn->default('');
            }

            if ($unique) {
                $indexColumn->unique();
            } else {
                $indexColumn->index();
            }
        }
    }
}
