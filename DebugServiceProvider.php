<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug;

use Illuminate\Contracts\Foundation\Application;
use Laradic\Config\Traits\ConfigProviderTrait;
use Laradic\Support\ServiceProvider;

/**
 * Class DebugServiceProvider
 *
 * @package     Laradic\Debug
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
class DebugServiceProvider extends ServiceProvider
{
    use ConfigProviderTrait;

    public function boot()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = parent::boot();
        \Debugger::log('debug:app:getBindings', $app->getBindings());
        \Debugger::log('debug:app:getLoadedProviders', $app->getLoadedProviders());
        \Debugger::log('debug:app:config', $app->make('config')->all());
        $this->loadViewsFrom(__DIR__.'/resources/ide-helper', 'laradic-ide-helper');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = parent::register();

        $this->addConfigComponent('laradic/debug', 'laradic/debug', realpath(__DIR__ . '/resources/config'));

        $app->register('Laradic\Debug\Providers\DebugbarServiceProvider');
        $app->register('Laradic\Debug\Providers\RouteServiceProvider');
        $app->register('Laradic\Debug\Providers\TracyServiceProvider');
        $app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');


        /** @var \Laradic\Config\Repository $config */
        $config  = $app->make('config');
        $enabled = (
            ($config->get('laradic/debug::enabled') and ! $config->get('laradic/debug::onlyEnabledInDebugMode'))
            or
            ($config->get('laradic/debug::enabled') and $config->get('laradic/debug::onlyEnabledInDebugMode') and $config->get('app.debug'))
        );

        $app->singleton('laradic.logger', function (Application $app) use ($config, $enabled)
        {
            $logger = new LoggerFactory($app);
            $logger->setDefaultLoggers($config->get('laradic/debug::loggers'));
            if ( $enabled and $config->get('laradic/debug::logging') )
            {
                $logger->enable();
            }
            else
            {
                $logger->disable();
            }
            return $logger;
        });

        $app->singleton('laradic.debugger', function (Application $app) use ($config, $enabled)
        {
            $logger = $app->make('laradic.logger');

            $debugger = new Debugger($app, $logger);

            if ($enabled)
            {
                $debugger->enable();
            }
            else
            {
                $debugger->disable();
            }
            return $debugger;
        });
        $this->alias('Debugger', 'Laradic\Debug\Facades\Debugger');


        if ( $this->app->runningInConsole() and $enabled)
        {
            $this->app->register('Laradic\Debug\Providers\ConsoleServiceProvider');
        }
    }
}
