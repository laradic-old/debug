<?php

namespace Laradic\Debug\Loggers;
 /**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package     Laradic\Debug\Loggers
 * @author      Robin Radic
 * @license     MIT
 * @copyright   (c) 2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
use File;
use Illuminate\Foundation\Application;
use Laradic\Debug\Contracts\Logger;
/**
 * ChromeLogger
 *
 * @package Laradic\Debug\Loggers\ChromeLogger
 */
class TracyLogger extends AbstractLogger
{
    public function __construct(Application $app)
    {
        parent::__construct($app); // TODO: Change the autogenerated stub

    }


    public function log()
    {
        $args = func_get_args();
        foreach($args as $arg){
            \Tracy\Debugger::getLogger()->log($arg, 'info');
        }
        return $this;
    }

    public function debug()
    {
        $args = func_get_args();
        foreach($args as $arg){
            \Tracy\Debugger::getLogger()->log($arg, 'debug');
        }

        return $this;
    }

    public function warn()
    {
        $args = func_get_args();
        foreach($args as $arg){
            \Tracy\Debugger::getLogger()->log($arg, 'warning');
        }
        return $this;

    }

    public function info()
    {
        $args = func_get_args();
        foreach($args as $arg){
            \Tracy\Debugger::getLogger()->log($arg, 'info');
        }
        return $this;

    }

    public function error()
    {
        $args = func_get_args();
        foreach($args as $arg){
            \Tracy\Debugger::getLogger()->log($arg, 'error');
        }
        return $this;

    }
}
