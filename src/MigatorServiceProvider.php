<?php

declare(strict_types=1);

namespace Synetic\Migator;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Synetic\Migator\Commands\AboutCommand;
use Synetic\Migator\Commands\CreateCommand;
use Synetic\Migator\Service\Formatter;
use Synetic\Migator\Service\Migration;
use Synetic\Migator\Service\Writer;

class MigatorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('Migator')
            ->hasCommands(
                AboutCommand::class,
                CreateCommand::class,
            );
    }

    /**
     * @throws InvalidPackage
     */
    public function register()
    {
        parent::register();
        $this->app->bind('migatorMigration', function () {
            return new Migration(new Formatter(), new Writer());
        });
    }
}
