<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug\Providers;

use Event;
use Illuminate\Support\ServiceProvider;


class DebugbarServiceProvider extends ServiceProvider
{


    /** @inheritdoc */
    public function boot()
    {
        if ( $this->app->runningInConsole() )
        {
            return;
        }
        $app = $this->app;

        #Debugger::log('sdf');
        Event::listen('bootstrapping', function () use ($app)
        {
            # echo '<br><br><br><br><br>';

            /** @var \Barryvdh\Debugbar\LaravelDebugbar $debugbar */
            $debugbar = $app->make('debugbar');
            $jsr      = $debugbar->getJavascriptRenderer();
            # $jsr->setIncludeVendors(false);
            $jsr->disableVendor('fontawesome');
            $jsr->disableVendor('jquery'); // jquery, highlightjs, fontawesome,
            $col = $jsr->getAsseticCollection();
            /** @var \Assetic\Asset\AssetCollection $css */
            $css = $col[0];


            \View::share('debugbar_css', $css->dump());
            /** @var \Assetic\Asset\AssetCollection $js */
            $js     = $col[1];
            $render = str_replace('<script type="text/javascript">', '', $jsr->render());
            $render = str_replace('</script>', '', $render);
            \View::share('debugbar_js', $js->dump() . "\n;\n" . $render);
            #$response['debugbar_css'] = '';
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        $debugbar = $this->app->make('debugbar');
        $debugbar->disable();

        if ( $this->app->config->get('debug.debugbar') and ! $this->app->runningInConsole() )
        {

            $debugbar->enable();
            $debugbar->getJavascriptRenderer()->setEnableJqueryNoConflict(false);
            $this->app->alias('Debugbar', 'Barryvdh\Debugbar\Facade');
        }
    }
}