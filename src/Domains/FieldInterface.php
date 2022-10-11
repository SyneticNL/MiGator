<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

interface FieldInterface
{
    public function toMigrationString(string $column): string;
}
