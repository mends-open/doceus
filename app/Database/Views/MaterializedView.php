<?php

namespace App\Database\Views;

use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class MaterializedView
{
    protected ?string $rawQuery = null;
    protected ?Builder $builder = null;

    /** @var string[] */
    protected array $indexes = [];

    public function __construct(protected string $name) {}

    /**
     * Set the underlying query for the view.
     */
    public function query(Closure|Builder|string $query): static
    {
        if ($query instanceof Closure) {
            $query = $query();
        }

        if ($query instanceof Builder) {
            $this->builder = $query;
            $this->rawQuery = null;
        } elseif (is_string($query)) {
            $this->builder = null;
            $this->rawQuery = $query;
        } else {
            throw new InvalidArgumentException('Query must be a Closure, Builder, or SQL string.');
        }

        return $this;
    }

    /**
     * Pass-through for builder methods; supports chaining.
     */
    public function __call(string $method, array $parameters)
    {
        // Initialize empty builder if neither is set.
        if (!$this->builder) {
            $this->builder = DB::query();
        }

        $result = $this->builder->$method(...$parameters);

        // If it's a builder, allow chaining.
        return $result instanceof Builder ? $this : $result;
    }

    /**
     * Add an index or unique index.
     */
    protected function addIndex(array|string $columns, ?string $name, bool $unique): static
    {
        $columnsArr = is_array($columns) ? $columns : [$columns];
        $columnsList = implode(', ', $columnsArr);

        $indexName = $name ?? $this->generateIndexName($columnsArr, $unique);
        $uniqueSql = $unique ? 'UNIQUE ' : '';

        $this->indexes[] = "CREATE {$uniqueSql}INDEX {$indexName} ON {$this->name} ({$columnsList})";
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
        return strtolower($this->name . '_' . implode('_', $columns) . '_' . $type);
    }

    /**
     * Create the materialized view and its indexes.
     */
    public function create(): static
    {
        $query = $this->rawQuery;

        if ($this->builder) {
            // Use toRawSql if available, otherwise fallback to toSql with parameters.
            $query = method_exists($this->builder, 'toRawSql')
                ? $this->builder->toRawSql()
                : $this->builder->toSql();
        }

        if (!$query) {
            throw new InvalidArgumentException('No query provided for materialized view.');
        }

        DB::statement("CREATE MATERIALIZED VIEW {$this->name} AS {$query}");

        foreach ($this->indexes as $sql) {
            DB::statement($sql);
        }

        return $this;
    }

    /**
     * Drop the materialized view if exists.
     */
    public function dropIfExists(): static
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS {$this->name} CASCADE");
        return $this;
    }

    /**
     * Refresh the materialized view.
     */
    public function refresh(bool $concurrently = false): static
    {
        $concurrent = $concurrently ? 'CONCURRENTLY ' : '';
        DB::statement("REFRESH MATERIALIZED VIEW {$concurrent}{$this->name}");
        return $this;
    }

    /**
     * Get the view's name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Quickly generate a distinct-on-latest query for this view.
     */
    public function latestPerGroup(array $grouping, string $orderColumn = 'created_at DESC', array $select = ['*']): static
    {
        $groupString = implode(', ', $grouping);
        $selectString = implode(', ', $select);

        $sql = <<<SQL
SELECT DISTINCT ON ({$groupString})
    {$selectString}
FROM {$this->name}_events
ORDER BY {$groupString}, {$orderColumn}
SQL;

        return $this->query($sql);
    }
}
