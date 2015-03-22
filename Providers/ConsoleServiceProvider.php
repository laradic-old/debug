<?php namespace Laradic\Dev\Providers;

use Laradic\Support\AbstractConsoleProvider;

class ConsoleServiceProvider extends AbstractConsoleProvider
{
    protected $namespace = 'Laradic\Dev\Console';
    protected $commands = [
        'Dev' => 'commands.radic.dev'
    ];
}
