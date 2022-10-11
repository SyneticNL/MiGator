<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldInterface;

class DateTimeType implements FieldInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('dateTime(\'%s\', $precision = 0);', $column);
    }
}
