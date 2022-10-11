<?php

declare(strict_types=1);

namespace Synetic\Migator\Commands;

use Illuminate\Console\Command;

class AboutCommand extends Command
{
    protected $signature = 'migator:about';

    protected $description = 'Test command';

    public function handle(): int
    {
        $this->info('Hello world!');

        return self::SUCCESS;
    }
}
