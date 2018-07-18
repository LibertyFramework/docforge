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

namespace Javanile\Elegy\Context;

trait TemplatesTrait
{


    public function getTemplateFile($name)
    {
        return $this->templatesDir . '/' . $name;
    }


}



