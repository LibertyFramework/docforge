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

namespace Javanile\DocForge;

class Compiler
{
    public function run($argv)
    {
        $configFile = getcwd().'/docforge.json';
        $builder = new Builder($configFile);
        $builder->run();
    }
}
