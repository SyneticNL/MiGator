<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldInterface;

class StringType implements FieldInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('string(\'%s\')', $column);
    }
}
