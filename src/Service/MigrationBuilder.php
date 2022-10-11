<?php

declare(strict_types=1);

namespace Synetic\Migator\Service;

use Illuminate\Support\Collection;
use Synetic\Migator\Domains\Entity;
use Synetic\Migator\Domains\EntityField;

class MigrationBuilder
{
    public function __construct(
        private Collection $entityCollection
    ) {
    }

    public function getBuildCollection(): Collection
    {
        return $this->entityCollection->mapWithKeys(function (Entity $entity) {
            return [
                $entity->tableName => $entity->entityFields->map(function (EntityField $entityField) {
                    return $entityField->entityType->toMigrationString($entityField->fieldName);
                })
            ];
        });
    }
}
