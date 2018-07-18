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

trait PagesTrait
{
    public function listRootPages()
    {
        $pages = [];

        foreach ($this->configData['pages'] as $id => $item) {
            if (is_array($item)) {

            } else {
                $pageClass = $this->getClassName($item);
                $pages[] = new $pageClass($this, $id);
            }
        }

        return $pages;
    }

    /**
     * @return array
     */
    public function listAllPages()
    {
        $pages = [];
        $this->listAllPagesRecursive($this->configData['pages'], $pages);

        return $pages;
    }

    /**
     * @param $struct
     * @param $pages
     */
    public function listAllPagesRecursive($struct, &$pages, $base = '')
    {
        foreach ($struct as $id => $item) {
            if (is_array($item)) {
                $this->listAllPagesRecursive($item, $pages, $base.$id.'/');
            } else {
                $pageClass = $this->getClassName($item);
                $pages[] = new $pageClass($this, $base.$id);
            }
        }
    }


}
