<?php

declare(strict_types=1);

namespace Synetic\Migator\Commands;

use Illuminate\Console\Command;
use Synetic\Migator\Domains\EntityField;
use Synetic\Migator\Domains\EntityTypes\BooleanType;
use Synetic\Migator\Domains\EntityTypes\TextType;

class CreateModelCommand extends Command
{
    protected $signature = 'migator:create-model';

    protected $description = 'Create model';

    public function handle(): int
    {
        $modelName = $this->ask('Model name');
        $this->info('Lets make '. $modelName .'!');

        $fields = collect();

        do {
            $fieldName = $this->ask('Field name');
            $fieldTypeName = $this->choice('Field types', array_keys($this->getEntityTypes()));
            $fieldType = new ($this->getEntityTypes()[$fieldTypeName]);
            $fields->push(new EntityField($fieldName, $fieldType));
        } while ($this->confirm('Would you like to add another field?'));

        $this->info('The following fields will be created for '. $modelName);
        $this->table(
            ['name', 'type'],
            $fields->map(function($field) {
                return [$field->fieldName, class_basename($field->entityType)];
            })
        );
        $this->confirm('Create migration');
        dd($fields);

        return self::SUCCESS;
    }

    private function getEntityTypes(): array
    {
        // TODO: Automatically find all the different field types
        return [
            'boolean' => BooleanType::class,
            'text' => TextType::class
        ];
    }

}
