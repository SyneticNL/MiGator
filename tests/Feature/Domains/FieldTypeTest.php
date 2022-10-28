<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Feature\Domains;

use Synetic\Migator\Domains\FieldTypeParameters\FieldTypeParameterInterface;
use Synetic\Migator\Domains\FieldTypes\BooleanType;
use Synetic\Migator\Domains\FieldTypes\DateTimeType;
use Synetic\Migator\Domains\FieldTypes\DecimalType;
use Synetic\Migator\Domains\FieldTypes\IntegerType;
use Synetic\Migator\Domains\FieldTypes\TextType;
use Synetic\Migator\Tests\TestCase;

class FieldTypeTest extends TestCase
{
    public function test_type_can_have_parameters(): void
    {
        $type = new DateTimeType();
        $this->assertInstanceOf(FieldTypeParameterInterface::class, $type->getParameters()->first());
    }

    public function test_we_can_set_parameter_value(): void
    {
        $type = new DateTimeType();
        $type->getParameters()->first()->setValue(10);
        $this->assertEquals(10, $type->getParameters()->first()->getValue());
    }

    public function test_parameters_are_processed(): void
    {
        $type = new DateTimeType();
        $this->assertEquals('dateTime(\'foo\')', $type->toMigrationString('foo'));

        $type = new DateTimeType();
        $type->getParameters()->first()->setValue(10);
        $this->assertEquals('dateTime(\'foo\', 10)', $type->toMigrationString('foo'));

        $type = new DateTimeType();
        $type->getParameters()->first()->setValue(null);
        $this->assertEquals('dateTime(\'foo\', null)', $type->toMigrationString('foo'));
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

    public function test_multiple_parameters_are_possible(): void
    {
        $type = new DecimalType();
        $type->getParameters()->first()->setValue(4);
        $type->getParameters()->last()->setValue(5);

        $this->assertEquals('decimal(\'foo\', 4, 5)', $type->toMigrationString('foo'));
    }

    public function test_multiple_parameters_with_default_value_can_be_omitted(): void
    {
        $type = new DecimalType();
        $type->getParameters()->first()->setValue(8);
        $type->getParameters()->last()->setValue(2);

        $this->assertEquals('decimal(\'foo\')', $type->toMigrationString('foo'));

        $type->getParameters()->first()->setValue(4);
        $type->getParameters()->last()->setValue(2);

        $this->assertEquals('decimal(\'foo\', 4)', $type->toMigrationString('foo'));
    }

    public function test_multiple_parameters_with_default_value_before_others_cannot_be_omitted(): void
    {
        $type = new DecimalType();
        $type->getParameters()->first()->setValue(8);
        $type->getParameters()->last()->setValue(4);

        $this->assertEquals('decimal(\'foo\', 8, 4)', $type->toMigrationString('foo'));
    }
}
