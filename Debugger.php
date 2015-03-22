<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug;

use Illuminate\Contracts\Foundation\Application;
use Laradic\Debug\Tracy\BarPanel;
use Laradic\Support\Str;
use Symfony\Component\VarDumper\VarDumper;
use Tracy\DefaultBarPanel;
/**
 * Class DebugFactory
 *
 * @package     Laradic\Debug
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
class Debugger
{

    protected $logger;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    public function __construct(Application $application, LoggerFactory $logger)
    {
        $this->app    = $application;
        $this->logger = $logger;
    }

    public function dump()
    {
        return forward_static_call_array(['Symfony\Component\VarDumper\VarDumper', 'dump'], func_get_args());
    }

    public function kint($var)
    {
        return \Kint::dump($var);
    }

    public function log()
    {
        if ( $this->app->runningInConsole() )
        {
            call_user_func_array([$this, 'dump'], func_get_args());
        }
        call_user_func_array([$this->logger, 'info'], func_get_args());
    }

    public function tracy($title, $var, $options = [])
    {
        $panel = new BarPanel('dumps');
        \Tracy\Debugger::getBar()->addPanel($panel);

        $panel->data[] = array('title' => $title, 'dump' => \Tracy\Dumper::toHtml($var, (array) $options + array(
                \Tracy\Dumper::DEPTH => \Tracy\Debugger::$maxDepth,
                \Tracy\Dumper::TRUNCATE => \Tracy\Debugger::$maxLen,
                \Tracy\Dumper::LOCATION => \Tracy\Debugger::$showLocation,
            )));
    }
}