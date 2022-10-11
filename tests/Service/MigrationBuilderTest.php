<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Service;

use Synetic\Migator\Domains\Model;
use Synetic\Migator\Domains\Field;
use Synetic\Migator\Domains\FieldTypes\BooleanType;
use Synetic\Migator\Domains\FieldTypes\TextType;
use Synetic\Migator\Service\MigrationBuilder;
use Synetic\Migator\Tests\TestCase;

class MigrationBuilderTest extends TestCase
{
    public function test_it_builds(): void
    {
        $model = new Model('foo');
        $model->addField(new Field('bar', new TextType()));
        $model->addField(new Field('baz', new BooleanType()));

        $builder = new MigrationBuilder(collect([$model]));

        $this->assertEquals(
            ['foos' => ['text(\'bar\')', 'boolean(\'baz\')']],
            $builder->getBuildCollection()->toArray()
        );
    }
}
