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
    public static function isSlug($slug)
    {
        return preg_match('/^[a-z][a-z0-9-]+$/i', $slug);
    }

    public static function isGlob($glob)
    {
        return preg_match('/\*/', $glob);
    }

    /**
     *
     */
    public static function sanitizeSlug($slug)
    {
        return $slug;
    }

    /**
     * @param $file
     * @return string
     */
    public static function getFileSlug($file)
    {
        return strtr(pathinfo($file, PATHINFO_BASENAME), '.', '-');
    }
}

