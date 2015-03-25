<?php
 /**
 * Part of the Radic packages.
 */
namespace Laradic\Debug\Console;
use Laradic\Support\AbstractConsoleCommand;

/**
 * Class ListBindingsCommand
 *
 * @package     Laradic\Debug\Console
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
class ListBindingsCommand extends AbstractConsoleCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'debug:bindings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->dump(array_keys(app()->getBindings()));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
           # ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
           # ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
