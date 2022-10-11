<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class Entity
{
    public Collection $entityFields;

    private bool $tableExists;

    private array $columns = [];

    public function __construct(
        public string $tableName,
    ) {
        $this->tableExists = false;//Schema::hasTable($this->tableName);
        $this->entityFields = collect();
    }

    public function addEntityField(EntityField $entityField): void
    {
        $this->entityFields->add($entityField);
    }

    public function exists(): bool
    {
        return $this->tableExists;
    }

    public function columnExists($columnName): bool
    {
//        if (array_key_exists($columnName, $this->columns)) {
//            return $this->columns[$columnName];
//        }
//
//        $this->columns[$columnName] = Schema::hasColumn($this->tableName, $columnName);
//        return $this->columns[$columnName];
        return false;
    }
}
