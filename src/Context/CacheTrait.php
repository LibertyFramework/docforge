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

use Javanile\Elegy\Functions;
use Javanile\Elegy\Page;

trait CacheTrait
{
    /**
     *
     */
    protected $cache = [];

    /**
     *
     */
    public function hasCache($method, $key = null)
    {
        return $key !== null
            ? isset($this->cache[$method][$key])
            : isset($this->cache[$method]);
    }

    /**
     * @param $page
     */
    public function getCache($method, $key = null)
    {
        return $key !== null
            ? $this->cache[$method][$key]
            : $this->cache[$method];
    }

    /**
     * @return mixed
     */
    public function setCache($method, $key, $value = null)
    {
        if ($value !== null) {
            $this->cache[$method][$key] = $value;
        } else {
            $this->cache[$method] = $key;
            $value = $key;
        }

        return $value;
    }
}
