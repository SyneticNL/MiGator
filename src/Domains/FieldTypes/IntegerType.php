<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldInterface;

class IntegerType implements FieldInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('integer(\'%s\')', $column);
    }
}
