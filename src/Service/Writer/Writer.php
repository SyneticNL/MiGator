<?php

namespace Synetic\Migator\Service\Writer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class Writer
{
    public function write(Collection $builderCollection): bool
    {
        $up = $this->formatBuilderCollectionToUp($builderCollection);
        $migration = $this->createMigration($up, $builderCollection->keys());
        var_dump(database_path('migrations/' . $this->getMigrationName()));
        die();
        $storagePath = database_path('migrations/' . $this->getMigrationName());

        return File::put($storagePath, $migration);
    }

    public function formatBuilderCollectionToUp(Collection $builderCollection): string
    {
        return $builderCollection->mapWithKeys(function ($item, $key) {
            $createSchema = 'Schema::create(\''.$key.'\', static function (Blueprint $table) {';
            $fields = $item->map(static function ($item) {
                return '$table->'.$item.';'.PHP_EOL;
            })->implode(' ');
            $closeCreateSchema = '});';

            return collect([$createSchema.$fields.$closeCreateSchema]);
        })->implode('/N');
    }

    public function createMigration(string $up, Collection $keys): string
    {
        $template = File::get(__DIR__.'/../../../stubs/MigatorTemplate.stub');

        return str_replace(
            ['{{ up }}'],
            [$up],
            $template
        );
    }

    public function getMigrationName(): string
    {
        return 'migration.php';
    }
}
