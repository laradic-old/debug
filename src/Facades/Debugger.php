<?php namespace Laradic\Debug\Facades;

/**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package    dev9
 * @author     Robin Radic
 * @license    MIT
 * @copyright  (c) 2011-2015, Robin Radic
 * @link       http://radic.mit-license.org
 */
use Illuminate\Support\Facades\Facade;
/**
 * Debugger
 *
 * @package Laradic\BladeExtensions\Facades${NAME}
 */
class Debugger extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'laradic.debugger';
    }
}
