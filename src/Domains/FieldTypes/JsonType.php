<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldInterface;

class JsonType implements FieldInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('json(\'%s\')', $column);
    }
}
