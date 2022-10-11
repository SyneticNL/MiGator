<?php

use Illuminate\Support\Collection;

class MigrationBuilder
{
    public function __construct(
        private Collection $entityCollection
    ) {
    }

    public function getBuildCollection(): Collection
    {
        return collect();
    }
}
