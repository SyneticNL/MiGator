<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Service;

use Synetic\Migator\Domains\Entity;
use Synetic\Migator\Domains\EntityField;
use Synetic\Migator\Domains\EntityFieldTypes\BooleanType;
use Synetic\Migator\Domains\EntityFieldTypes\TextType;
use Synetic\Migator\Service\MigrationBuilder;
use Synetic\Migator\Tests\TestCase;

class MigrationBuilderTest extends TestCase
{
    public function test_it_builds(): void
    {
        $entity = new Entity('foo');
        $entity->addEntityField(new EntityField('bar', new TextType()));
        $entity->addEntityField(new EntityField('baz', new BooleanType()));

        $builder = new MigrationBuilder(collect([$entity]));

        $this->assertEquals(
            ['foos' => ['text(\'bar\')', 'boolean(\'baz\')']],
            $builder->getBuildCollection()->toArray()
        );
    }
}
