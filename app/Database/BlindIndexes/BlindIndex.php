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

    public function column(string $name): BlindIndexColumn
    {
        return new BlindIndexColumn($this->table, $name);
    }

    /**
     * Convenience method to add multiple columns at once.
     *
     * @param array<string, array|bool> $columns
     */
    public function columns(array $columns): void
    {
        foreach ($columns as $column => $options) {
            $builder = $this->column($column);

            if (is_bool($options)) {
                if ($options) {
                    $builder->unique();
                }
            } elseif (is_array($options)) {
                if (($options['unique'] ?? false) === true) {
                    $builder->unique();
                }
                if (($options['nullable'] ?? false) === true) {
                    $builder->nullable();
                }
            }

            $builder->apply();
        }
    }
}

class BlindIndexColumn
{
    protected bool $unique = false;
    protected bool $nullable = false;
    protected bool $applied = false;

    public function __construct(protected Blueprint $table, protected string $name)
    {
    }

    public function unique(bool $value = true): static
    {
        $this->unique = $value;
        return $this;
    }

    public function nullable(bool $value = true): static
    {
        $this->nullable = $value;
        return $this;
    }

    public function apply(): void
    {
        if ($this->applied) {
            return;
        }

        $textColumn = $this->table->text($this->name);
        if ($this->nullable) {
            $textColumn->nullable()->default(null);
        }

        $indexColumn = $this->table->char($this->name . '_blind_index', 64)->default('');
        if ($this->nullable) {
            $indexColumn->nullable()->default(null);
        }

        if ($this->unique) {
            $indexColumn->unique();
        } else {
            $indexColumn->index();
        }

        $this->applied = true;
    }

    public function __destruct()
    {
        $this->apply();
    }
}
