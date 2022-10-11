<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

class EntityField
{
    public function __construct(
        public string $tableName,
        public EntityTypeInterface $entityType
    ) {
    }
}
