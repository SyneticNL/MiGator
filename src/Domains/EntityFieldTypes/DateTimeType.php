<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\EntityFieldTypes;

use Synetic\Migator\Domains\EntityTypeInterface;

class DateTimeType implements EntityTypeInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('dateTime(\'%s\', $precision = 0);', $column);
    }

}
