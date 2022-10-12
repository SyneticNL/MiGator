<?php

declare(strict_types=1);

namespace Synetic\Migator\Service\Writer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class Writer
{
    /**
     * @param  Collection<string, array>  $builderCollection
     */
    public function write(Collection $builderCollection): bool
    {
        $up = $this->formatBuilderCollectionToUp($builderCollection);
        $migration = $this->createMigration($up);
        $storagePath = database_path().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.$this->getMigrationName(
            $builderCollection->keys()
        );

        return (bool) File::put($storagePath, $migration);
    }

    /**
     * @param  Collection<string, array>  $builderCollection
     */
    public function formatBuilderCollectionToUp(Collection $builderCollection): string
    {
        return $builderCollection->mapWithKeys(function ($item, $key) {
            $fields = $item['fields']->map(static function ($item) {
                return '$table->'.$item.';';
            })->implode(' ');

            if ($item['model']->exists()) {
                return [$key => $this->formatBuilderCollectionUpdate($fields, $key)];
            }

            return [$key => $this->formatBuilderCollectionCreate($fields, $key)];
        })->implode(PHP_EOL.PHP_EOL);
    }

    public function formatBuilderCollectionUpdate(string $fields, string $tableName): string
    {
        $template = File::get(__DIR__.'/../../../stubs/migator.update.stub');

        return str_replace(
            ['{{ table }}', '{{ fields }}'],
            [$tableName, $fields],
            $template
        );
    }

    public function formatBuilderCollectionCreate($fields, $tableName): string
    {
        $template = File::get(__DIR__.'/../../../stubs/migator.create.stub');

        return str_replace(
            ['{{ table }}', '{{ fields }}'],
            [$tableName, $fields],
            $template
        );
    }

    public function createMigration(string $up): string
    {
        $template = File::get(__DIR__.'/../../../stubs/migator.stub');

        return str_replace(
            ['{{ up }}'],
            [$up],
            $template
        );
    }

    public function getMigrationName(Collection $models): string
    {
        return date('Y_m_d_His').'_create_'.$models->implode('_').'_migration.php';
    }
}
