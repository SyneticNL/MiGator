<?php

declare(strict_types=1);

namespace Synetic\Migator\Commands;

use Carbon\Doctrine\DateTimeType;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Synetic\Migator\Domains\Entity;
use Synetic\Migator\Domains\EntityField;
use Synetic\Migator\Domains\EntityFieldTypes\BooleanType;
use Synetic\Migator\Domains\EntityFieldTypes\DateType;
use Synetic\Migator\Domains\EntityFieldTypes\IntegerType;
use Synetic\Migator\Domains\EntityFieldTypes\TextType;

class CreateCommand extends Command
{
    protected $signature = 'migator:create';

    protected $description = 'Create entity';

    public function handle(): int
    {
        $entities = collect();

        do {
            $this->handleEntity($entities);
        } while ($this->confirm('Would you like to work on another entity?'));

        return self::SUCCESS;
    }

    private function handleEntity(Collection $entities): void
    {
        $entity = new Entity(
            $this->ask('Table name')
        );

        $existMessage = $entity->exists() ? 'Entity already exists' : 'Entity does not exist yet';
        $this->info($existMessage);

        $this->info('Lets configure fields for '.$entity->tableName.'!');

        do {
            $fieldName = $this->ask('Field name');

            if ($entity->columnExists($fieldName)) {
                $this->warn('This field already exists.');
                continue;
            }

            $fieldTypeName = $this->choice('Field types', $this->getEntityTypes()->keys()->toArray());
            $fieldType = new ($this->getEntityTypes()->get($fieldTypeName));
            $entity->addEntityField(new EntityField($fieldName, $fieldType));
        } while ($this->confirm('Would you like to add another field?'));

        $this->info('The following fields will be created for '.$entity->tableName);
        $this->table(
            ['name', 'type'],
            $entity->entityFields->map(function ($field) {
                return [$field->fieldName, class_basename($field->entityType)];
            })
        );
        if ($this->confirm('Build entity?')) {
            $entities->push($entity);
        } else {
            $this->warn('Cancelled entity creations');
        }
    }

    private function getEntityTypes(): Collection
    {
        // TODO: Automatically find all the different field types
        return collect([
            'boolean' => BooleanType::class,
            'text' => TextType::class,
            'date-time' => DateTimeType::class,
            'date' => DateType::class,
            'integer' => IntegerType::class,
        ]);
    }
}
