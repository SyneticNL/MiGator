<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

interface FieldTypeInterface
{
    /**
     * This method will generate the actual migration code to be used.
     */
    public function toMigrationString(string $column): string;

    public function __toString(): string;

    public function setDefault(mixed $default): static;

    public function getDefault(): mixed;
}
