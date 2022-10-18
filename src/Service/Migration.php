<?php

declare(strict_types=1);

namespace Synetic\Migator\Service;

use Illuminate\Support\Collection;

class Migration
{
    public function __construct(
        private Formatter $formatter,
        private Writer $writer
    ) {
    }

    public function create(Collection $modelCollection): bool
    {
        $contents = $this->formatter->render($modelCollection);

        return $this->writer->write($contents, $modelCollection->pluck('tableName'));
    }
}
