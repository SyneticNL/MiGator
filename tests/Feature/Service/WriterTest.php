<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Feature\Service;

use Synetic\Migator\Service\Writer;
use Synetic\Migator\Tests\TestCase;

class WriterTest extends TestCase
{
    public function test_migration_name(): void
    {
        $writer = new Writer();
        $this->assertStringEndsWith('user_name_migration.php', $writer->getMigrationName(collect(['user', 'name'])));
    }
}
