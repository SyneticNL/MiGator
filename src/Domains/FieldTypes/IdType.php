<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldInterface;

class IdType implements FieldInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('id()');
    }
}
