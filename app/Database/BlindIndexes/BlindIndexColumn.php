<?php

namespace App\Database\BlindIndexes;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

class BlindIndexColumn
{
    protected ColumnDefinition $textColumn;
    protected ColumnDefinition $blindColumn;
    protected bool $unique = false;

    public function __construct(protected Blueprint $table, protected string $name)
    {
        $this->textColumn = $this->table->text($this->name);
        $this->blindColumn = $this->table->char($this->name . '_blind', 64)->default('');
    }

    /**
     * Mark the blind column as unique.
     */
    public function unique(): static
    {
        $this->blindColumn->unique();
        $this->unique = true;

        return $this;
    }

    /**
     * Make the columns nullable.
     */
    public function nullable(): static
    {
        $this->textColumn->nullable()->default(null);
        $this->blindColumn->nullable()->default(null);

        return $this;
    }

    public function __destruct()
    {
        if (!$this->unique) {
            $this->blindColumn->index();
        }
    }
}
