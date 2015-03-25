<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Debug\Console;

use Illuminate\Support\Arr;
use Laradic\Support\AbstractConsoleCommand;

class ConfigShowCommand extends AbstractConsoleCommand
{
    protected $name = 'debug:config:show';
    protected $description = 'Show all config values';

    public function fire()
    {
       # $this->dump($config);

        $rows = [];
        foreach(Arr::dot(app('config')->all()) as $key => $val){
            if(is_bool($val))
            {
                $val = $val === true ? $this->colorize('green', 'true') : $this->colorize('red', 'false');
            }
            $rows[] = [$key, $val];
        }
        $this->table(['Key/Path', 'Value'], $rows);
    }
}
