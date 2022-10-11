<?php

namespace Synetic\Migator\Service\Writer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;

class Writer
{
    public function write(Collection $builderCollection): bool
    {
        $up = $this->formatBuilderCollectionToUp($builderCollection);
        $migration = $this->createMigration($up);
        $storagePath = database_path().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.$this->getMigrationName($builderCollection->keys());

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
        })->implode(PHP_EOL.PHP_EOL);
    }

    public function createMigration(string $up): string
    {
        $template = File::get(__DIR__.'/../../../stubs/MigatorTemplate.stub');

        return str_replace(
            ['{{ up }}'],
            [$up],
            $template
        );
    }

    public function getMigrationName(Collection $entityKeys): string
    {
        return  Date::create()->format('Y_m_d_h_i_s').$entityKeys->implode('_').'migration.php';
    }
}
