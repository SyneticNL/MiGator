<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Feature\Service;

use Synetic\Migator\Domains\Field;
use Synetic\Migator\Domains\FieldTypes\IdType;
use Synetic\Migator\Domains\FieldTypes\IntegerType;
use Synetic\Migator\Domains\FieldTypes\TextType;
use Synetic\Migator\Domains\Model;
use Synetic\Migator\Service\Formatter;
use Synetic\Migator\Tests\TestCase;

class FormatterTest extends TestCase
{
    private Formatter $formatter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formatter = new Formatter();
    }

    public function test_it_renders_as_expected(): void
    {
        $model = new Model('foo');
        $model->addField(new Field('id', new IdType()));
        $model->addField(new Field('baz', new TextType()));
        $model->addField(new Field('bar', new IntegerType()));

        $model2 = new Model('bar');
        $model2->addField(new Field('foo', new TextType()));

        $modelCollection = collect([$model, $model2]);

        $result = $this->formatter->render($modelCollection);

        $this->assertStringEqualsFile(__DIR__.'/FormatterTest/expected.create.php', $result);
    }

    public function test_it_can_handle_empty_collection(): void
    {
        $result = $this->formatter->render(collect());
        $this->assertSame('', $result);
    }

    public function test_it_updates_existing_models(): void
    {
        $model = new Model('user');
        $model->addField(new Field('baz', new TextType()));

        $model2 = new Model('bar');
        $model2->addField(new Field('baz', new TextType()));

        $modelCollection = collect([$model, $model2]);

        $result = $this->formatter->render($modelCollection);

        $this->assertStringEqualsFile(__DIR__.'/FormatterTest/expected.update.php', $result);
    }
}
