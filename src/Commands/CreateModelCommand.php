<?php

declare(strict_types=1);

namespace Synetic\Migator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Synetic\Migator\Domains\Entity;
use Synetic\Migator\Domains\EntityField;
use Synetic\Migator\Domains\EntityTypes\BooleanType;
use Synetic\Migator\Domains\EntityTypes\TextType;

class CreateModelCommand extends Command
{
    protected $signature = 'migator:create-model';

    protected $description = 'Create model';

    public function handle(): int
    {
        $entities = collect();

        do {
            $entity = new Entity(
                $this->ask('Table name')
            );

            $this->info('Lets make '. $entity->tableName .'!');

            do {
                $fieldName = $this->ask('Field name');
                $fieldTypeName = $this->choice('Field types', $this->getEntityTypes()->keys()->toArray());
                $fieldType = new ($this->getEntityTypes()->get($fieldTypeName));
                $entity->addEntityField(new EntityField($fieldName, $fieldType));
            } while ($this->confirm('Would you like to add another field?'));

            $this->info('The following fields will be created for '. $entity->tableName);
            $this->table(
                ['name', 'type'],
                $entity->entityFields->map(function($field) {
                    return [$field->fieldName, class_basename($field->entityType)];
                })
            );
            if ($this->confirm('Create entity')) {
                $entities->push($entity);
            } else {
                $this->warn('Cancelled entity creations');
            }

        } while ($this->confirm('Would you like to create another entity?'));

        return self::SUCCESS;
    }

    private function getEntityTypes(): Collection
    {
        // TODO: Automatically find all the different field types
        return collect([
            'boolean' => BooleanType::class,
            'text' => TextType::class
        ]);
    }

}
