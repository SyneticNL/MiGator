<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Feature\Domains;

use Synetic\Migator\Domains\Entity;
use Synetic\Migator\Tests\TestCase;

class EntityTest extends TestCase
{

    public function providerTestCanDetect(): array
    {
        return [
            'can detect existing table' => ['users', true,],
            'can detect not existing table' => ['test', false,],
        ];
    }

    /**
     * @dataProvider providerTestCanDetect
     */
    public function testCanDetect($table, $expected): void
    {
        static::assertEquals($expected, (new Entity($table))->exists());
    }
}
