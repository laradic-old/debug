<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug\Console;

use Laradic\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class ConfigShowCommand extends Command
{

    protected $name = 'debug:config:show';

    protected $description = 'Show all config values';

    public function fire()
    {
        # $this->dump($config);
        $conf = array_dot(app('config')->all());
        file_put_contents(base_path('test-radic.php'), var_export($conf, true));
        if ( $this->option('dump') )
        {
            $this->dump($conf);
        }
        else
        {
            $rows = [ ];
            foreach ( $conf as $key => $val )
            {
                if ( is_bool($val) )
                {
                    $val = $val === true ? $this->colorize('green', 'true') : $this->colorize('red', 'false');
                }
                $rows[ ] = [ $key, $val ];
            }
            $this->table([ 'Key/Path', 'Value' ], $rows);
        }
    }

    protected function getOptions()
    {
        return [
            [ 'dump', 'd', InputOption::VALUE_NONE, 'dump instead of table', null ]
        ];
    }
}
