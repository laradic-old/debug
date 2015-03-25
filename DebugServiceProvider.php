<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\AliasLoader;
use Laradic\Support\ServiceProvider;
use Laradic\Config\Traits\ConfigProviderTrait;

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
        $app->make('laradic.debugger')->log('debug:app:getBindings', $app->getBindings());
        $app->make('laradic.debugger')->log('debug:app:getLoadedProviders', $app->getLoadedProviders());
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

        $app->singleton('laradic.logger', 'Laradic\Debug\LoggerFactory');
        $app->singleton('laradic.debugger', function (Application $app)
        {
            $logger = $app->make('laradic.logger');
            $logger->setDefaultLoggers($app->make('config')->get('laradic/debug::loggers'));
            return new Debugger($app, $logger);
        });
        $this->alias('Debugger', 'Laradic\Debug\Facades\Debugger');


        if($this->app->runningInConsole())
        {
            $this->app->register('Laradic\Debug\Providers\ConsoleServiceProvider');
        }
    }
}
