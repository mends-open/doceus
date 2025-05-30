<?php

namespace App\Database\Views;

use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MaterializedView
{
    protected ?string $rawQuery = null;

    protected ?Builder $builder = null;

    /**
     * SQL statements to create indexes for the view.
     *
     * @var string[]
     */
    protected array $indexes = [];

    public function __construct(protected string $name)
    {
    }

    public function query(Closure|Builder|string $query): static
    {
        if ($query instanceof Closure) {
            $query = $query();
        }

        if ($query instanceof Builder) {
            $this->builder = $query;
            $this->rawQuery = null;
        } else {
            $this->rawQuery = (string) $query;
            $this->builder = null;
        }

        return $this;
    }

    public function __call(string $method, array $parameters)
    {
        $this->builder ??= DB::query();

        $result = $this->builder->$method(...$parameters);

        return $result instanceof Builder ? $this : $result;
    }

    protected function addIndex(array|string $columns, ?string $name, bool $unique): static
    {
        $columnsList = $columns;

        if (is_array($columns)) {
            $columnsList = implode(', ', $columns);
        } else {
            $columns = [$columns];
        }

        $name ??= $this->generateIndexName($columns, $unique);

        $uniqueSql = $unique ? 'UNIQUE ' : '';
        $this->indexes[] = "CREATE {$uniqueSql}INDEX {$name} ON {$this->name} ({$columnsList})";

        return $this;
    }

    public function index(array|string $columns, ?string $name = null): static
    {
        return $this->addIndex($columns, $name, false);
    }

    public function unique(array|string $columns, ?string $name = null): static
    {
        return $this->addIndex($columns, $name, true);
    }

    public function uniqueIndex(string $name, array|string $columns): static
    {
        return $this->addIndex($columns, $name, true);
    }

    protected function generateIndexName(array $columns, bool $unique): string
    {
        $type = $unique ? 'unique' : 'index';
        return strtolower($this->name.'_'.implode('_', $columns).'_'.$type);
    }

    public function create(): void
    {
        $query = $this->rawQuery;

        if ($this->builder) {
            $query = $this->builder->toRawSql();
        }

        DB::statement("CREATE MATERIALIZED VIEW {$this->name} AS {$query}");

        foreach ($this->indexes as $sql) {
            DB::statement($sql);
        }
    }

    public function dropIfExists(): void
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS {$this->name} CASCADE");
    }

    public function refresh(bool $concurrently = false): void
    {
        $concurrent = $concurrently ? 'CONCURRENTLY ' : '';
        DB::statement("REFRESH MATERIALIZED VIEW {$concurrent}{$this->name}");
    }

    public function name(): string
    {
        return $this->name;
    }
}
