<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Feature\Domains;

use Synetic\Migator\Domains\FieldTypeParameters\IntegerFieldTypeParameter;
use Synetic\Migator\Domains\FieldTypeParameters\StringFieldTypeParameter;
use Synetic\Migator\Tests\TestCase;

class FieldTypeParameterTest extends TestCase
{

    public function integerDataProvider(): array
    {
        return [
            [0, false],
            [100, false],
            ['foo', true],
            ['100', true],
            [null, true],
            [[], true],
        ];
    }

    /**
     * @dataProvider integerDataProvider
     * @throws \Throwable
     */
    public function test_integer_type_allows_only_integers(mixed $value, bool $expectException): void
    {
        $parameter = new IntegerFieldTypeParameter('foo', 0);

        if ($expectException) {
            $this->expectException(\UnexpectedValueException::class);
        }

        $parameter->setValue($value);
        $this->assertTrue(true);
    }

    /**
     * @throws \Throwable
     */
    public function test_it_returns_default_value_if_not_set(): void
    {
        $parameter = new IntegerFieldTypeParameter('foo', 0);
        $this->assertEquals(0, $parameter->getValue());

        $parameter->setValue(0);
        $this->assertEquals(0, $parameter->getValue());

        $parameter->setValue(10);
        $this->assertEquals('10', $parameter->getValue());
    }

    /**
     * @throws \Throwable
     */
    public function test_it_converts_value_to_string(): void
    {
        $parameter = new IntegerFieldTypeParameter('foo', 0, true);
        $parameter->setValue(10);
        $this->assertEquals(10, $parameter->getValue());

        $parameter->setValue(null);
        $this->assertEquals('null', $parameter->getValue());

        $parameter = new StringFieldTypeParameter('foo', '');
        $parameter->setValue('foo');
        $this->assertEquals('\'foo\'', $parameter->getValue());
    }

    /**
     * @throws \Throwable
     */
    public function test_it_detects_default_values(): void
    {
        $parameter = new IntegerFieldTypeParameter('foo', 4);
        $this->assertTrue($parameter->hasDefaultValue());

        $parameter->setValue(4);
        $this->assertTrue($parameter->hasDefaultValue());

        $parameter = new IntegerFieldTypeParameter('foo', null, true);
        $parameter->setValue(null);
        $this->assertTrue($parameter->hasDefaultValue());

        $parameter = new IntegerFieldTypeParameter('foo', 4);
        $parameter->setValue(5);
        $this->assertFalse($parameter->hasDefaultValue());
    }

}
