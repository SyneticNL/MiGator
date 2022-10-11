<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Feature\Domains;

use Synetic\Migator\Domains\Field;
use Synetic\Migator\Domains\FieldTypes\StringType;
use Synetic\Migator\Domains\Model;
use Synetic\Migator\Tests\TestCase;

class ModelTest extends TestCase
{
    public function providerTestCanDetect(): array
    {
        return [
            'can detect existing table' => ['user', true],
            'can detect existing table with capital casing' => ['User', true],
            'can detect not existing table' => ['test', false],
        ];
    }

    /**
     * @dataProvider providerTestCanDetect
     */
    public function testCanDetect($table, $expected): void
    {
        static::assertEquals($expected, (new Model($table))->exists());
    }

    public function providerTestCanDetectFieldsExist(): array
    {
        return [
            'can detect column exists on table' => ['user', 'name', true],
            'can detect column does not eist on table' => ['user', 'random', false],
        ];
    }

    /**
     * @dataProvider providerTestCanDetectFieldsExist
     */
    public function testCanDetectFieldsExist($table, $field, $expected): void
    {
        $model = new Model($table);
        static::assertEquals($expected, $model->columnExists($field));
        if (! $expected) {
            $model->addField(new Field($field, new StringType));
            static::assertEquals(true, $model->columnExists($field));
        }
    }
}
