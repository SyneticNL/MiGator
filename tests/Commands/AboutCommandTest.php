<?php

declare(strict_types=1);

namespace Synetic\Migator\Tests\Commands;

class AboutCommandTest extends \Synetic\Migator\Tests\TestCase {

  public function test_it_has_the_about_signature(): void {
    $this->artisan('migator:about')
      ->assertExitCode(0);
  }

}