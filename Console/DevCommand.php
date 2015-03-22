<?php namespace Laradic\Dev\Console;

use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use Laradic\Docs\DocServiceProvider;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DevCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'radic:dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->comment('List = ' . print_r(DocServiceProvider::compiles(), true));
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
