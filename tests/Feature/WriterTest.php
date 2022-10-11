<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Commands;

use Synetic\Migator\Service\Writer\Writer;
use Synetic\Migator\Tests\TestCase;

class WriterTest extends TestCase
{
    private Writer $writer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->writer = app(Writer::class);
    }

    public function test_writer_formatter_empty_collection(): void
    {
        $build = collect();
        $result = $this->writer->formatBuilderCollectionToCreateSchemaCollection($build);
        $this->assertSame($result, '');
    }
}
