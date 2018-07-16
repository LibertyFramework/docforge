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

class Page
{
    /**
     * Constructor.
     */
    public function __construct($context)
    {
        $this->context = $context
    }


    public function render()
    {
        $layoutFile = $context->getLayoutFile('index.php');

        include $layoutFile;
    }



}
