<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug\Console;


use Laradic\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ConfigGetCommand extends Command
{

    protected $name = 'debug:config:get';

    protected $description = 'Get a config value';

    protected $help = "Yo mama";

    public function fire()
    {
        $args = $this->argument();

        if ( ! isset($args['key']) )
        {
            $args['key'] = $this->ask('What key/path do you want to show? (leave empty if you want to show all)');
        }
        $val = app('config')->get($args['key']);

        $this->info('Showing ' . $this->colorize(['bold', 'yellow'], $args['key']));
        $this->dump($val);
    }


    protected function getArguments()
    {
        return array(
            array('key', InputArgument::OPTIONAL, 'The key/path')
        );
    }
}
