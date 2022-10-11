<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\EntityFieldTypes;

use Synetic\Migator\Domains\EntityTypeInterface;

class IntegerType implements EntityTypeInterface
{
    public function toMigrationString(): string
    {
        return '';
    }
}
