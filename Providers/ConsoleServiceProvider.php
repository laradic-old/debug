<?php namespace Laradic\Debug\Providers;

use Laradic\Support\AbstractConsoleProvider;

class ConsoleServiceProvider extends AbstractConsoleProvider
{
    protected $namespace = 'Laradic\Debug\Console';
    protected $commands = [
        'Dev' => 'commands.radic.dev',
        'ConfigGet' => 'commands.laradic.debug.config.get',
        'ConfigSet' => 'commands.laradic.debug.config.set',
        'ConfigShow' => 'commands.laradic.debug.config.show',
        'ListBindings' => 'command.laradic.debug.bindings'
    ];
}
