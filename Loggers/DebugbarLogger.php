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
use Debugbar;
use Laradic\Debug\Contracts\Logger;
/**
 * ChromeLogger
 *
 * @package Laradic\Debug\Loggers\ChromeLogger
 */
class DebugbarLogger extends AbstractLogger
{


    public function log()
    {

        $args = func_get_args();
        foreach($args as $arg)
        {
            $this->app->make('debugbar')->addMessage($arg, 'log');
        }
        return $this;
    }

    public function debug()
    {
        $args = func_get_args();
        foreach($args as $arg)
        {
            $this->app->make('debugbar')->addMessage($arg, 'debug');
        }
        return $this;
    }

    public function warn()
    {
        $args = func_get_args();
        foreach($args as $arg)
        {
            $this->app->make('debugbar')->addMessage($arg, 'warning');
        }
        return $this;
    }

    public function info()
    {
        $args = func_get_args();
        foreach($args as $arg)
        {
            $this->app->make('debugbar')->addMessage($arg, 'info');
        }
        return $this;
    }

    public function error()
    {
        $args = func_get_args();
        foreach($args as $arg)
        {
            $this->app->make('debugbar')->addMessage($arg, 'error');
        }
        return $this;
    }
}
