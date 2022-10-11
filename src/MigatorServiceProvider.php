<?php

declare(strict_types=1);

namespace Synetic\Migator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Synetic\Migator\Commands\AboutCommand;
use Synetic\Migator\Commands\CreateModelCommand;

class MigatorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('Migator')
            ->hasCommands(
                AboutCommand::class,
                CreateModelCommand::class,
            );
    }
}
