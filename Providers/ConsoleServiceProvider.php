<?php namespace Laradic\Debug\Providers;

use Laradic\Debug\Console\MetaCommand;
use Laradic\Support\AbstractConsoleProvider;

class ConsoleServiceProvider extends AbstractConsoleProvider
{

    protected $namespace = 'Laradic\Debug\Console';

    protected $commands = [
        'Dev'          => 'commands.radic.dev',
        'ConfigGet'    => 'commands.laradic.debug.config.get',
        'ConfigSet'    => 'commands.laradic.debug.config.set',
        'ConfigShow'   => 'commands.laradic.debug.config.show',
        'ListBindings' => 'command.laradic.debug.bindings',
    ];

    public function register()
    {
        parent::register();
        $this->app['command.ide-helper.meta'] = $this->app->share(function ($app)
        {
            return new MetaCommand($app['files'], $app['view']);
        } );
    }

    public function provides()
    {
        return array_merge(parent::provides(), ['command.ide-helper.meta']);
    }
}
