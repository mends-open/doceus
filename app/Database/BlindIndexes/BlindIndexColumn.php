<?php

namespace App\Database\BlindIndexes;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

class BlindIndexColumn
{
    protected ColumnDefinition $textColumn;

    protected ColumnDefinition $indexColumn;

    protected bool $unique = false;

    public function __construct(protected Blueprint $table, protected string $name)
    {
        $this->textColumn = $this->table->text($this->name);
        $this->indexColumn = $this->table->char($this->name.'_blind_index', 64)->default('');
    }

    /**
     * Mark the blind index column as unique.
     */
    public function unique(): static
    {
        $this->indexColumn->unique();
        $this->unique = true;

        return $this;
    }

    /**
     * Make the columns nullable.
     */
    public function nullable(): static
    {
        $this->textColumn->nullable()->default(null);
        $this->indexColumn->nullable()->default(null);

        return $this;
    }

    public function __destruct()
    {
        if (! $this->unique) {
            $this->indexColumn->index();
        }
    }
}
