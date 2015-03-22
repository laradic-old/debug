<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use \Tracy\Debugger as Dbg;

class TracyServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ( $this->app['config']->get('laradic/debug::tracy') and class_exists('\Tracy\Debugger') )
        {
            \Tracy\Debugger::enable();
            \Tracy\Debugger::$logDirectory = storage_path('tracy');
            if ( ! $this->app['files']->isDirectory(storage_path('tracy')) )
            {
                $this->app['files']->makeDirectory(storage_path('tracy'), 0777, true);
            }
        }
    }
}