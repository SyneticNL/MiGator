<?php

namespace Synetic\Migator\Tests\Commands;

use Synetic\Migator\Service\Migration;
use Synetic\Migator\Tests\TestCase;

class CreateCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->mock(Migration::class)->shouldReceive('create');
    }

    public function test_happy_flow(): void
    {
        $this->artisan('migator:create')
            ->expectsQuestion('Model name', 'FooUser')
            ->expectsQuestion('Field name', 'name')
            ->expectsQuestion('Field types', 'id')
            ->expectsQuestion('Default value', 'defaultValue')
            ->expectsConfirmation('Would you like to add another field?', 'no')
            ->expectsConfirmation('Do you want to build the model [fooUsers]?', 'yes')
            ->expectsConfirmation('Would you like to work on another model?', 'no')
            ->assertExitCode(0);
    }

    public function test_cancel_flow(): void
    {
        $this->artisan('migator:create')
            ->expectsQuestion('Model name', 'FooUser')
            ->expectsQuestion('Field name', 'name')
            ->expectsQuestion('Field types', 'id')
            ->expectsQuestion('Default value', 'defaultValue')
            ->expectsConfirmation('Would you like to add another field?', 'no')
            ->expectsConfirmation('Do you want to build the model [fooUsers]?', 'no')
            ->expectsConfirmation('Would you like to work on another model?', 'no')
            ->assertExitCode(0);
    }
}
