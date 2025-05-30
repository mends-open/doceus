<?php

namespace App\Database\Views;

use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MaterializedView
{
    protected string $name;

    protected string $query;

    /** @var string[] */
    protected array $indexes = [];

    public static function make(string $name): static
    {
        $instance = new static;
        $instance->name = $name;

        return $instance;
    }

    public function query(Closure|Builder|string $query): static
    {
        if ($query instanceof Closure) {
            $query = $query();
        }

        if ($query instanceof Builder) {
            $query = $query->toRawSql();
        }

        $this->query = $query;

        return $this;
    }

    public function index(string $name, array|string $columns, bool $unique = false): static
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $uniqueSql = $unique ? 'UNIQUE ' : '';
        $this->indexes[] = "CREATE {$uniqueSql}INDEX {$name} ON {$this->name} ({$columns})";

        return $this;
    }

    public function uniqueIndex(string $name, array|string $columns): static
    {
        return $this->index($name, $columns, true);
    }

    public function create(): void
    {
        DB::statement("CREATE MATERIALIZED VIEW {$this->name} AS {$this->query}");

        foreach ($this->indexes as $sql) {
            DB::statement($sql);
        }
    }

    public function drop(): void
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS {$this->name} CASCADE");
    }

    public function refresh(bool $concurrently = false): void
    {
        $concurrent = $concurrently ? 'CONCURRENTLY ' : '';
        DB::statement("REFRESH MATERIALIZED VIEW {$concurrent}{$this->name}");
    }
}
