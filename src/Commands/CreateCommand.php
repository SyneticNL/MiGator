<?php

declare(strict_types=1);

namespace Synetic\Migator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Synetic\Migator\Domains\Field;
use Synetic\Migator\Domains\FieldTypeInterface;
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

class CreateCommand extends Command
{
    protected $signature = 'migator:create {model? : The model you\'re going to generate a migration for.}';

    protected $description = 'Create a migration.';

    private Collection $fieldTypes;

    public function __construct()
    {
        parent::__construct();
        $this->fieldTypes = $this->getFieldTypes();
    }

    public function handle(): int
    {
        $models = new Collection();
        do {
            $models->push($this->handleModel(new Model((string) ($this->argument('model') ?? $this->ask('Model name')))));
        } while ($this->confirm('Would you like to work on another model?', true));

        $success = app('migatorMigration')->create($models);
        if ($success) {
            $this->info('Migration created, Get to tha choppa! ᕦ(ò_óˇ)ᕤ ');

            return self::SUCCESS;
        }
        $this->error('Arnold wasn\'t able to generate your migration. I\'ll be back.');

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

            $choice = $this->choice('Field type', $this->fieldTypes->keys()->toArray());

            if (is_string($choice)) {
                $fieldType = $this->fieldTypes->get($choice);
                if ($fieldType !== null) {
                    $defaultValue = $this->ask('Default value');
                    $fieldType->setDefault($defaultValue);
                    $model->addField(new Field($name, $fieldType));
                }
            }
        } while ($this->confirm('Would you like to add another field?', true));

        $this->info('The following fields will be created for '.$model->tableName.':');
        $this->table(
            ['name', 'type', 'defaultValue'],
            $model->fields->map(function (Field $field) {
                return [
                    $field->name,
                    (string) $field->type,
                    $field->type->getDefault(),
                ];
            })
        );

        if (! $this->confirm('Do you want to build the model ['.$model->tableName.']?', true)) {
            $this->warn('Cancelled build');
        }

        return $model;
    }

    /**
     * @return Collection<string,FieldTypeInterface>
     */
    private function getFieldTypes(): Collection
    {
        return collect([
            new IdType(),
            new StringType(),
            new IntegerType(),
            new DateTimeType(),
            new TextType(),
            new BooleanType(),
            new DateType(),
            new JsonType(),
            new UuidType(),
        ])->mapWithKeys(fn (FieldTypeInterface $fieldType) => [
            (string) $fieldType => $fieldType,
        ]);
    }
}
