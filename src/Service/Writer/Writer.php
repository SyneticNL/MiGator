<?php

namespace Synetic\Migator\Service\Writer;

use Illuminate\Support\Collection;

class Writer implements WriterInterface {

    //['users' => ['id()', 'string(\'name\')']]
    public function write(Collection $builderCollection): bool
    {
        $createSchemaCollection = $this->formatBuilderCollectionToCreateSchemaCollection($builderCollection);

        return false;
    }

    public function formatBuilderCollectionToCreateSchemaCollection(Collection $builderCollection): string
    {
        return $builderCollection->mapWithKeys(static function ($item, $key) {
            $createSchema = 'Schema::create('. $key . ', static function (Blueprint $table) {';
            $fields = $item->map((static function ($item) {
                return '$table->'. $item . ';';
            }));
            $closeCreateSchema = '});';
            return $createSchema . $fields . $closeCreateSchema;
        })->implode('\N');

    }

}
