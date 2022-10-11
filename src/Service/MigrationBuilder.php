<?php

declare(strict_types=1);

namespace Synetic\Migator\Service;

use Illuminate\Support\Collection;
use Synetic\Migator\Domains\Model;
use Synetic\Migator\Domains\Field;

class MigrationBuilder
{
    public function __construct(
        private Collection $modelCollection
    ) {
    }

    public function getBuildCollection(): Collection
    {
        return $this->modelCollection->mapWithKeys(function (Model $model) {
            return [
                $model->tableName => $model->fields->map(function (Field $field) {
                    return $field->type->toMigrationString($field->name);
                }),
            ];
        });
    }
}
