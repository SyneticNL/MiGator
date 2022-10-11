<?php

declare(strict_types=1);

namespace Synetic\Migator\Service;

use Illuminate\Support\Collection;
use Synetic\Migator\Service\Writer\Writer;

class Migration
{
    public function create(Collection $modelCollection): bool
    {
        return (new Writer())->write((new MigrationBuilder($modelCollection))->getBuildCollection());
    }
}
