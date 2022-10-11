<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldInterface;

class DateType implements FieldInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('date(\'%s\')', $column);
    }
}
