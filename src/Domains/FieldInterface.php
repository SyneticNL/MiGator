<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

interface FieldInterface
{
    /**
     * This is the method that will generate the actual migration code to be used.
     */
    public function toMigrationString(string $column): string;
}
