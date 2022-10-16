<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Service;

use Synetic\Migator\Domains\Field;
use Synetic\Migator\Domains\FieldTypes\IdType;
use Synetic\Migator\Domains\FieldTypes\IntegerType;
use Synetic\Migator\Domains\FieldTypes\TextType;
use Synetic\Migator\Domains\Model;
use Synetic\Migator\Service\Formatter;
use Synetic\Migator\Tests\TestCase;

class FormatterTest extends TestCase
{
    public function test_it_renders_as_expected(): void
    {
        $model = new Model('foo');
        $model->addField(new Field('id', new IdType()));
        $model->addField(new Field('baz', new TextType()));
        $model->addField(new Field('bar', new IntegerType()));

        $model2 = new Model('bar');
        $model2->addField(new Field('foo', new TextType()));

        $modelCollection = collect([$model, $model2]);

        $result = (new Formatter())->render($modelCollection);

        $this->assertStringEqualsFile(__DIR__ . '/FormatterTest/expected.php', $result);
    }
}
