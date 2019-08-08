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

class Functions
{
    public static function isClass($class)
    {
        return is_class($class);
    }

    public static function isSlug($slug)
    {
        return preg_match('/^[a-z]+$/', $slug);
    }

    public static function isGlob($glob)
    {
        return preg_match('/\*/', $slug);
    }

    /**
     *
     */
    public static function sanitizeSlug($slug)
    {
        return $slug;
    }
}

