<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Commands;

use Synetic\Migator\Tests\TestCase;

class AboutCommandTest extends TestCase
{
    public function test_it_has_the_about_signature(): void
    {
        $this->artisan('migator:about')
          ->assertExitCode(0);
    }
}
