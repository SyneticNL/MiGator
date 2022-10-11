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

    private string $testCreateString = 'Schema::create(\'tests\', static function (Blueprint $table) {$table->id(); $table->string(\'name\');});'.PHP_EOL;
    private string $testUpdateString = 'Schema::table(\'users\', static function (Blueprint $table) {$table->string(\'gps\'); $table->string(\'alter_ego\');});'.PHP_EOL;

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

    public function test_writer_create_formatter(): void
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
            $this->testCreateString, $result
        );
    }

    public function test_create_replace_in_template(): void
    {
        $result = $this->writer->createMigration($this->testCreateString);
        $this->assertSame(File::get(__DIR__.'/fixtures/WriterCreateTestsResult.txt'), $result);
    }

    public function test_update_create_formatter(): void
    {
        $build = collect(['users' => [
            'model' => new Model('users'),
            'fields' => collect([
                'string(\'gps\')',
                'string(\'alter_ego\')',
            ])
        ]]);

        $result = $this->writer->formatBuilderCollectionToUp($build);
        $this->assertSame(
            $this->testUpdateString, $result
        );
    }

    public function test_update_replace_in_template(): void
    {
        $result = $this->writer->createMigration($this->testUpdateString);
        $this->assertSame(File::get(__DIR__.'/fixtures/WriterUpdateUsersResult.txt'), $result);
    }

    public function test_migration_name(): void
    {
        $this->assertStringEndsWith('user_name_migration.php', $this->writer->getMigrationName(collect(['user', 'name'])));
    }
}
