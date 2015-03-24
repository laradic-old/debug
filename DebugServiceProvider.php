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
    #protected $configFiles = ['debug'];
    protected $dir = __DIR__;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        parent::register();
        $path = realpath(__DIR__ . '/resources/config');
        $this->addConfigComponent('laradic/debug', 'laradic/debug', $path);

        $this->app->register('Laradic\Debug\Providers\RouteServiceProvider');
        $this->app->register('Laradic\Debug\Providers\DebugbarServiceProvider');
        $this->app->register('Laradic\Debug\Providers\TracyServiceProvider');
        $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');

        $this->app->singleton('laradic.logger', 'Laradic\Debug\LoggerFactory');
        #AliasLoader::getInstance()->alias('Logger', 'Laradic\Debug\Facades\Logger');
        $this->app->singleton('laradic.debugger', function (Application $app)
        {
            $logger = $app->make('laradic.logger');
            $config = $app['config'];

            $logger->setDefaultLoggers($config->get('laradic/debug::loggers'));
            return new Debugger($app, $logger);
        });
        AliasLoader::getInstance()->alias('Debugger', 'Laradic\Debug\Facades\Debugger');
    }
}
