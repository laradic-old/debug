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

    /** @inheritdoc */
    public function boot()
    {
        parent::register();
        # \Debugger::dump('Laradic Debugger');
        #  \Tracy\Debugger::getBar()->addPanel(new DefaultBarPanel("events"), 'Laradic:events');
        #\Debugger::log('ya fist', ['ya' => 'fist']);
       # \Debugger::tracy('config', $this->app['config']->all());
  /*      \Debugger::tracy('bindings', $this->app->getBindings(),[
            'collapse' => 2,
            'collapsecount' => 2
        ]);
        \Debugger::tracy('loaded providers', $this->app->getLoadedProviders(), [
            'collapse' => 2,
            'collapsecount' => 2
        ]);
*/
       # $this->app->
        /* @var \Barryvdh\Debugbar\LaravelDebugbar $debugbar */
        /*$debugbar = $this->app->make('debugbar');
        foreach($debugbar->collect() as $name => $data)
        {

        }*/


    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
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

            $logger->setDefaultLoggers($app['config']->get('laradic/debug::loggers'));
            return new Debugger($app, $logger);
        });
        AliasLoader::getInstance()->alias('Debugger', 'Laradic\Debug\Facades\Debugger');
    }
}
