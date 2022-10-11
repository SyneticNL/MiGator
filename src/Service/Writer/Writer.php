<?php

declare(strict_types=1);

namespace Synetic\Migator\Service\Writer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class Writer
{
    public function write(Collection $builderCollection): bool
    {
        $up = $this->formatBuilderCollectionToUp($builderCollection);
        $migration = $this->createMigration($up);
        $storagePath = database_path().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.$this->getMigrationName(
            $builderCollection->keys()
        );

        return (bool) File::put($storagePath, $migration);
    }

    public function formatBuilderCollectionToUp(Collection $builderCollection): string
    {
        return $builderCollection->mapWithKeys(function ($item, $key) {
            $createSchema = 'Schema::create(\''.$key.'\', static function (Blueprint $table) {';
            $fields = $item->map(static function ($item) {
                return '$table->'.$item.';';
            })->implode(' ');
            $closeCreateSchema = '});';

            return collect([$createSchema.$fields.$closeCreateSchema]);
        })->implode(PHP_EOL.PHP_EOL);
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

    public function getMigrationName(Collection $entityKeys): string
    {
        return date('Y_m_d_His').'_create_'.$entityKeys->implode('_').'_migration.php';
    }
}
