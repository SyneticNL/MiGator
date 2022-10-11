<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

use Illuminate\Support\Collection;

class Entity
{
    public Collection $entityFields;

    public function __construct(
        public string $tableName,
    ) {
        $this->entityFields = collect();
    }

    public function addEntityField(EntityField $entityField): void
    {
        $this->entityFields->add($entityField);
    }
}
