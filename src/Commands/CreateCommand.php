<?php

declare(strict_types=1);

namespace Synetic\Migator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Synetic\Migator\Domains\Field;
use Synetic\Migator\Domains\FieldTypes\BooleanType;
use Synetic\Migator\Domains\FieldTypes\DateTimeType;
use Synetic\Migator\Domains\FieldTypes\DateType;
use Synetic\Migator\Domains\FieldTypes\IdType;
use Synetic\Migator\Domains\FieldTypes\IntegerType;
use Synetic\Migator\Domains\FieldTypes\JsonType;
use Synetic\Migator\Domains\FieldTypes\StringType;
use Synetic\Migator\Domains\FieldTypes\TextType;
use Synetic\Migator\Domains\FieldTypes\UuidType;
use Synetic\Migator\Domains\Model;
use Synetic\Migator\Service\Migration;

class CreateCommand extends Command
{
    protected $signature = 'migator:create {model? : The model you\'re going to generate a migration for.}';

    protected $description = 'Create a migration.';

    public function handle(): int
    {
        $entities = collect();
        do {
            $entities->push($this->handleModel(new Model($this->argument('model') ?? $this->ask('Model name'))));
        } while ($this->confirm('Would you like to work on another model?', true));

        $success = (new Migration())->create($entities);
        if ($success) {
            $this->info('Migration created, you are going to live.');

            return self::SUCCESS;
        }
        $this->error('Arnold wasn\'t able to generate your migration. Get to tha choppa!');

        return self::FAILURE;
    }

    private function handleModel(Model $model): Model
    {
        $existMessage = $model->exists() ? 'Model already exists' : 'Model does not exist yet';
        $this->info($existMessage);

        $this->info('Let\'s configure fields for '.$model->tableName.'!');

        do {
            $name = $this->ask('Field name');

            if ($model->columnExists($name)) {
                $this->warn('This field already exists.');

                continue;
            }

            $fieldTypeName = $this->choice('Field types', $this->getFieldTypes()->keys()->toArray());
            $fieldType = new ($this->getFieldTypes()->get($fieldTypeName))();
            $model->addField(new Field($name, $fieldType));
        } while ($this->confirm('Would you like to add another field?', true));

        $this->info('The following fields will be created for '.$model->tableName.':');
        $this->table(
            ['name', 'type'],
            $model->fields->map(function ($field) {
                return [$field->name, class_basename($field->type)];
            })
        );

        if (! $this->confirm('Do you want to build the model ['.$model->tableName.']?', true)) {
            $this->warn('Cancelled build');
        }

        return $model;
    }

    private function getFieldTypes(): Collection
    {
        // TODO: Automatically discover all different field types
        return collect([
            'id' => IdType::class,
            'string' => StringType::class,
            'integer' => IntegerType::class,
            'date-time' => DateTimeType::class,
            'text' => TextType::class,
            'boolean' => BooleanType::class,
            'date' => DateType::class,
            'json' => JsonType::class,
            'uuid' => UuidType::class,
        ]);
    }
}
