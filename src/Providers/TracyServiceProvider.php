<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug\Providers;

use Illuminate\Foundation\AliasLoader;
use Laradic\Support\ServiceProvider;
use Laradic\Debug\Tracy\BarPanel;
use \Tracy\Debugger as Dbg;

class TracyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = parent::boot();

        if ( $this->app['config']->get('laradic/debug::tracy') and class_exists('\Tracy\Debugger') )
        {
            $app->make('laradic.debugger')->log('tracy');
        }
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

        if ( $this->app['config']->get('laradic/debug::tracy') and class_exists('\Tracy\Debugger') )
        {
            Dbg::enable();
            Dbg::getBar()->addPanel(new BarPanel('dumps'), 'Tracy:dumps');

            Dbg::$logDirectory = storage_path('tracy');
            if ( ! $this->app['files']->isDirectory(storage_path('tracy')) )
            {
                $this->app['files']->makeDirectory(storage_path('tracy'), 0777, true);
            }
        }
    }
}
