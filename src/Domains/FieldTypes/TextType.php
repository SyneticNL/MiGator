<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldInterface;

class TextType implements FieldInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('text(\'%s\')', $column);
    }
}
