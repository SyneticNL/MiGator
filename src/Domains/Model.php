<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Model
{
    /**
     * @var Collection<int, Field>
     */
    public Collection $fields;

    private bool $tableExists;

    private array $columns = [];

    public string $tableName;

    public function __construct(
        public string $model,
    ) {
        $this->tableName = Str::camel(Str::plural($model));
        $this->tableExists = Schema::hasTable($this->tableName);
        $this->fields = new Collection();
    }

    public function addField(Field $field): void
    {
        $this->fields->add($field);
    }

    public function exists(): bool
    {
        return $this->tableExists;
    }

    public function columnExists(string $columnName): bool
    {
        if ($this->fields->filter(function ($item) use ($columnName) {
            return $item->name === $columnName;
        })->isNotEmpty()) {
            return true;
        }

        if (array_key_exists($columnName, $this->columns)) {
            return $this->columns[$columnName];
        }

        $this->columns[$columnName] = Schema::hasColumn($this->tableName, $columnName);

        return $this->columns[$columnName];
    }
}
