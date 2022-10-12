<?php

declare(strict_types=1);

namespace Synetic\Migator\Service;

use Illuminate\Support\Collection;
use Synetic\Migator\Domains\Field;
use Synetic\Migator\Domains\Model;

class MigrationBuilder
{

    /**
     * @param \Illuminate\Support\Collection<int, Model> $modelCollection
     */
    public function __construct(
        private Collection $modelCollection
    ) {
    }

    public function getBuildCollection(): Collection
    {
        return $this->modelCollection->mapWithKeys(function (Model $model) {
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
