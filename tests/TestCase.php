<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Synetic\Migator\MigatorServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            MigatorServiceProvider::class,
        ];
    }
}
