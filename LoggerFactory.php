<?php namespace Laradic\Debug;

use Illuminate\Contracts\Foundation\Application;
use Laradic\Debug\Contracts\Logger;
use Laradic\Debug\Loggers\ChromeLogger;
use Laradic\Debug\Loggers\DebugbarLogger;
use Laradic\Debug\Loggers\FirelogLogger;
use Laradic\Debug\Loggers\NativeLogger;
use Laradic\Debug\Loggers\TracyLogger;


/**
 * Path
 *
 * @package Laradic\Debug${NAME}
 */
class LoggerFactory implements Logger
{

    protected $enabled = false;

    protected $to = [];

    protected $defaultTo = [];

    protected $loggers = ['chrome', 'firelog', 'debugbar', 'tracy'];

    /** @var \Laradic\Debug\Contracts\Logger */
    protected $chrome;

    /** @var \Laradic\Debug\Contracts\Logger */
    protected $firelog;

    /** @var \Laradic\Debug\Contracts\Logger */
    protected $debugbar;

    /** @var \Laradic\Debug\Contracts\Logger */
    protected $tracy;

    /**
     * Creates a new logger Factory instance
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->chrome   = new ChromeLogger($app);
        $this->firelog  = new FirelogLogger($app);
        $this->debugbar = new DebugbarLogger($app);
        $this->tracy    = new TracyLogger($app);
    }

    public function enable()
    {
        $this->enabled = true;
        return $this;
    }

    public function disable()
    {
        $this->enabled = false;
        return $this;
    }

    public function isEnabled()
    {
        return $this->enabled === true ? true : false;
    }

    public function setDefaultLoggers($loggers)
    {
        $this->defaultTo = [];
        foreach($loggers as $logger => $enabled)
        {
            if(!$enabled)
            {
                continue;
            }
            $this->defaultTo[] = $logger;
        }
    }

    /** @return Logger */
    public function chrome()
    {
        return $this->chrome;
    }

    /** @return Logger */
    public function firelog()
    {
        return $this->firelog;
    }

    /** @return Logger */
    public function debugbar()
    {
        return $this->debugbar;
    }

    /** @return Logger */
    public function tracy()
    {
        return $this->tracy;
    }



    public function to()
    {
        $loggers = func_get_args();
        if (is_array($loggers[0]) && !isset($loggers[1]))
        {
            $loggers = $loggers[0];
        }

        $this->to = [];
        foreach ($loggers as $logger)
        {
            if (in_array($logger, $this->loggers))
            {
                $this->to[] = $logger;
            }
            else
            {
                throw new \ErrorException("Logger $logger not available. Use any of: [" . implode(", ", $this->loggers) . "]");
            }
        }

        return $this;
    }

    /** @return LoggerFactory */
    public function log()
    {
        $to = !empty($this->to) ? $this->to : $this->defaultTo;
        foreach ($to as $logger)
        {
            call_user_func_array([$this->{$logger}, 'log'], func_get_args());
        }

        return $this;
    }

    /** @return LoggerFactory */
    public function debug()
    {
        $to = !empty($this->to) ? $this->to : $this->defaultTo;
        foreach ($to as $logger)
        {
            call_user_func_array([$this->{$logger}, 'debug'], func_get_args());
        }

        return $this;
    }

    /** @return LoggerFactory */
    public function warn()
    {
        $to = !empty($this->to) ? $this->to : $this->defaultTo;
        foreach ($to as $logger)
        {
            call_user_func_array([$this->{$logger}, 'warn'], func_get_args());
        }

        return $this;
    }

    /** @return LoggerFactory */
    public function info()
    {
        $to = !empty($this->to) ? $this->to : $this->defaultTo;
        foreach ($to as $logger)
        {
            call_user_func_array([$this->{$logger}, 'info'], func_get_args());
        }

        return $this;
    }

    /** @return LoggerFactory */
    public function error()
    {
        $to = !empty($this->to) ? $this->to : $this->defaultTo;
        foreach ($to as $logger)
        {
            call_user_func_array([$this->{$logger}, 'error'], func_get_args());
        }

        return $this;
    }
}
