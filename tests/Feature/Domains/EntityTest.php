<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Feature\Domains;

use Synetic\Migator\Domains\Model;
use Synetic\Migator\Tests\TestCase;

class ModelTest extends TestCase
{
    public function providerTestCanDetect(): array
    {
        return [
            'can detect existing table' => ['user', true],
            'can detect existing table with capital casing' => ['User', true],
            'can detect not existing table' => ['test', false],
        ];
    }

    /**
     * @dataProvider providerTestCanDetect
     */
    public function testCanDetect($table, $expected): void
    {
        static::assertEquals($expected, (new Model($table))->exists());
    }
}
