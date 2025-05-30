<?php

namespace App\Database;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlindIndex
{
    protected Blueprint $table;

    protected array $columns = [];

    public static function table(Blueprint $table): static
    {
        $instance = new static();
        $instance->table = $table;
        return $instance;
    }

    public function columns(array $columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    public function add(): void
    {
        foreach ($this->columns as $column => $options) {
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

            $indexColumn = $this->table->char($column.'_blind_index', 64)->default('');
            if ($nullable) {
                $indexColumn->nullable()->default(null);
            }

            $unique ? $indexColumn->unique() : $indexColumn->index();
        }
    }

    public static function addColumns(Blueprint $table, array $columns): void
    {
        static::table($table)->columns($columns)->add();
    }

    public static function hash(string $value): string
    {
        $normalized = Str::of($value)->lower()->trim();
        $hmacKey = base64_decode(Str::after(env('APP_BLIND_INDEX_KEY'), 'base64:'));
        return hash_hmac('sha256', $normalized, $hmacKey);
    }

    public static function updateModel(Model $model): void
    {
        if (! method_exists($model, 'getBlindIndexFields')) {
            return;
        }

        foreach ($model->getBlindIndexFields() as $field) {
            if ($model->isDirty($field)) {
                $indexField = $field.'_blind_index';
                $model->{$indexField} = static::hash((string) $model->{$field});
            }
        }
    }
}
