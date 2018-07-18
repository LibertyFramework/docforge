<?php
/**
 * File description.
 *
 * PHP version 5
 *
 * @category -
 *
 * @author    -
 * @copyright -
 * @license   -
 */

namespace Javanile\Elegy;

class Cli
{
    public function run($argv)
    {
        $configFile = getcwd().'/elegy.json';
        $builder = new Builder($configFile);
        $builder->run();
    }
}
