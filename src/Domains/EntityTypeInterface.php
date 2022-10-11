<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

interface EntityTypeInterface
{
    public function toMigrationString(): string;
}
