<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug\Providers;

use Event;
use Laradic\Support\ServiceProvider;


class DebugbarServiceProvider extends ServiceProvider
{
    protected $providers = [
        'Barryvdh\Debugbar\ServiceProvider'
    ];

    public function boot()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = parent::boot();
        if ( $app->runningInConsole() )
        {
            return;
        }

        $app->make('events')->listen('bootstrapping', function () use ($app)
        {
            /** @var \Barryvdh\Debugbar\LaravelDebugbar $debugbar */
            $debugbar = $app->make('debugbar');
            $jsr      = $debugbar->getJavascriptRenderer();
            $jsr->disableVendor('fontawesome');
            $jsr->disableVendor('jquery'); // jquery, highlightjs, fontawesome,
            $col = $jsr->getAsseticCollection();
            /** @var \Assetic\Asset\AssetCollection $css */
            $css = $col[0];

            $view = $app->make('view');
            $view->share('debugbar_css', $css->dump());
            /** @var \Assetic\Asset\AssetCollection $js */
            $js     = $col[1];
            $render = str_replace('<script type="text/javascript">', '', $jsr->render());
            $render = str_replace('</script>', '', $render);
            $view->share('debugbar_js', $js->dump() . "\n;\n" . $render);
        });
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

        $debugbar = $app->make('debugbar');
        $debugbar->disable();

        if ( $app->make('config')->get('laradic/debug::debugbar') and ! $app->runningInConsole() )
        {
            $debugbar->enable();
            $debugbar->getJavascriptRenderer()->setEnableJqueryNoConflict(false);
            $this->alias('Debugbar', 'Barryvdh\Debugbar\Facade');
        }
    }
}
