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

<<<<<<< HEAD
    public function column(string $name): BlindIndexColumn
    {
        return new BlindIndexColumn($this->table, $name);
    }

    /**
     * Convenience method to add multiple columns at once.
     *
     * @param array<string, array|bool> $columns
=======
    /**
     * Add blind index columns to the table.
>>>>>>> feat/redesign-features
     */
    public function columns(array $columns): void
    {
        foreach ($columns as $column => $options) {
<<<<<<< HEAD
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
=======
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
>>>>>>> feat/redesign-features
