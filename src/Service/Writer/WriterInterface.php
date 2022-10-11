<?php

namespace Synetic\Migator\Service\Writer;

use Illuminate\Support\Collection;

interface WriterInterface
{
    public function write(Collection $builderCollection): bool;
}
