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
use Illuminate\Support\Str;
use Laradic\Debug\Contracts\Logger;
/**
 * ChromeLogger
 *
 * @package Laradic\Debug\Loggers\ChromeLogger
 */
abstract class AbstractLogger implements Logger
{
    protected $app;
    protected $factory;
    #protected $logger;
    public function __construct(Application $app)
    {
        $this->app = $app;
        #$this->logger = new \Monolog\Logger(String::random(10));

    }
}
