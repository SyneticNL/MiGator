<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldInterface;

class BooleanType implements FieldInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('boolean(\'%s\')', $column);
    }
}
