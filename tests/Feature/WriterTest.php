<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Feature;

use Illuminate\Support\Facades\File;
use Synetic\Migator\Domains\Model;
use Synetic\Migator\Service\Writer\Writer;
use Synetic\Migator\Tests\TestCase;

class WriterTest extends TestCase
{
    private Writer $writer;

    private string $testString = 'Schema::create(\'tests\', static function (Blueprint $table) {$table->id(); $table->string(\'name\');});'.PHP_EOL;

    protected function setUp(): void
    {
        parent::setUp();
        $this->writer = app(Writer::class);
    }

    public function test_writer_formatter_empty_collection(): void
    {
        $build = collect();
        $result = $this->writer->formatBuilderCollectionToUp($build);
        $this->assertSame($result, '');
    }

    public function test_writer_formatter(): void
    {
        $build = collect(['tests' => [
            'model' => new Model('tests'),
            'fields' => collect([
                'id()',
                'string(\'name\')',
            ]),
        ]]);

        $result = $this->writer->formatBuilderCollectionToUp($build);
        $this->assertSame(
            $this->testString, $result
        );
    }

    public function test_replace_in_template(): void
    {
        $result = $this->writer->createMigration($this->testString, collect(['users', 'typos']));
        $this->assertSame(File::get(__DIR__.'/fixtures/WriterTestResult.txt'), $result);
    }

    public function test_migration_name(): void
    {
        $this->assertStringEndsWith('user_name_migration.php', $this->writer->getMigrationName(collect(['user', 'name'])));
    }
}
