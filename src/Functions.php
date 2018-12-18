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

class Functions
{
    /**
     * @param $array
     * @return mixed
     */
    public static function getArrayFirstValueRecursive($array)
    {
        if (!is_array($array)) {
            return $array;
        }

        $firstValue = array_pop(array_reverse($array));

        if (is_array($firstValue)) {
            return static::getArrayFirstValueRecursive($firstValue);
        }

        return $firstValue;
    }
}
