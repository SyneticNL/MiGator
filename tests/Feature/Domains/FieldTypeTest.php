<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Feature\Domains;

use Synetic\Migator\Domains\FieldTypes\BooleanType;
use Synetic\Migator\Domains\FieldTypes\DateTimeType;
use Synetic\Migator\Domains\FieldTypes\IntegerType;
use Synetic\Migator\Domains\FieldTypes\TextType;
use Synetic\Migator\Tests\TestCase;

class FieldTypeTest extends TestCase
{
    public function test_parameters_are_processed(): void
    {
        $type = new DateTimeType();
        $this->assertEquals('dateTime(\'foo\', $precision = 0)', $type->toMigrationString('foo'));

        $type = new DateTimeType(10);
        $this->assertEquals('dateTime(\'foo\', $precision = 10)', $type->toMigrationString('foo'));

        $type = new DateTimeType(null);
        $this->assertEquals('dateTime(\'foo\', $precision = null)', $type->toMigrationString('foo'));
    }

    public function test_default_value_can_be_set(): void
    {
        $type = (new TextType())->setDefault('bar');
        $this->assertEquals('text(\'foo\')->default(\'bar\')', $type->toMigrationString('foo'));

        $type = (new IntegerType())->setDefault(1);
        $this->assertEquals('integer(\'foo\')->default(1)', $type->toMigrationString('foo'));

        $type = (new TextType())->setDefault(null);
        $this->assertEquals('text(\'foo\')->default(null)', $type->toMigrationString('foo'));

        $type = (new BooleanType())->setDefault(true);
        $this->assertEquals('boolean(\'foo\')->default(true)', $type->toMigrationString('foo'));
    }
}
