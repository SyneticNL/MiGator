<?php

declare(strict_types=1);

namespace Synetic\Migator\Service;

use Illuminate\Support\Collection;

class Writer
{
    public function write(string $contents, Collection $tableNames): bool
    {
        if (empty($contents)) {
            return false;
        }

        $storagePath = collect([
            database_path(),
            'migrations',
            $this->getMigrationName($tableNames)
        ])->implode(DIRECTORY_SEPARATOR);

        return (bool)file_put_contents($storagePath, $contents);
    }

    public function getMigrationName(Collection $models): string
    {
        return date('Y_m_d_His') . '_create_' . $models->implode('_') . '_migration.php';
    }
}
