<?php

declare(strict_types=1);

namespace Synetic\Migator\Service;

use Illuminate\Support\Collection;
use Synetic\Migator\Domains\Field;
use Synetic\Migator\Domains\Model;

class Formatter
{
    public function render(Collection $modelCollection): string
    {
        return str_replace(
            '{{ up }}',
            rtrim($this->renderUps($this->getBuildCollection($modelCollection))),
            file_get_contents(__DIR__ . '/../../stubs/migator.stub')
        );
    }

    public function renderUps(Collection $builderCollection): string
    {
        return $builderCollection->mapWithKeys(function ($item, $tableName) {
            $fields = $item['fields']->map(static function ($item) {
                return '            $table->' . $item . ';';
            })->implode(PHP_EOL);

            $stub = 'migator.' . ($item['model']->exists() ? 'update' : 'create') . '.stub';

            $up = str_replace(
                ['{{ table }}', '{{ fields }}'],
                [$tableName, $fields],
                file_get_contents(__DIR__ . '/../../stubs/' . $stub)
            );

            return [$tableName => $up];
        })->implode(PHP_EOL);
    }

    private function getBuildCollection(Collection $modelCollection): Collection
    {
        return $modelCollection->mapWithKeys(function (Model $model) {
            return [
                $model->tableName => [
                    'model' => $model,
                    'fields' => $model->fields->map(function (Field $field) {
                        return $field->type->toMigrationString($field->name);
                    }),
                ],
            ];
        });
    }
}
