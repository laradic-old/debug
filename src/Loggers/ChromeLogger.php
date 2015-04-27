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
use Illuminate\Foundation\Application;
use ChromePhp;
use Laradic\Debug\Contracts\Logger;
/**
 * ChromeLogger
 *
 * @package Laradic\Debug\Loggers\ChromeLogger
 */
class ChromeLogger extends AbstractLogger
{
    /** @inheritdoc */
    public function log()
    {

        #$this->logger->addInfo('log', func_get_args());
        call_user_func_array(['\ChromePhp', 'log'], func_get_args());
        return $this;
    }

    /** @inheritdoc */
    public function debug()
    {
        call_user_func_array(['\ChromePhp', 'debug'], func_get_args());
        return $this;
    }

    /** @inheritdoc */
    public function warn()
    {
        call_user_func_array(['\ChromePhp', 'warn'], func_get_args());
        return $this;
    }

    /** @inheritdoc */
    public function info()
    {
        call_user_func_array(['\ChromePhp', 'info'], func_get_args());
        return $this;
    }

    /** @inheritdoc */
    public function error()
    {
        call_user_func_array(['\ChromePhp', 'error'], func_get_args());
        return $this;
    }
}
