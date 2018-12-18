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

trait PagesTrait
{
    /**
     * @param $page
     */
    public function setCurrentPage($page)
    {
        $this->currentPage = $page;
    }

    /**
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param $page
     * @return bool
     */
    public function isCurrentPage($page)
    {
        return $this->currentPage->getSlug() == $page->getSlug();
    }

    /**
     * @return array
     */
    public function listRootPages()
    {
        if ($this->rootPages !== null) {
            return $this->rootPages;
        }

        $this->rootPages = [];

        foreach ($this->configData['pages'] as $id => $item) {
            if (is_array($item)) {
                $item = Functions::getArrayFirstValueRecursive($item);
            }
            $pageClass = $this->getClassName($item);
            $this->rootPages[] = new $pageClass($this, $id);
        }

        return $this->rootPages;
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

    /**
     * @return mixed
     */
    public function getCurrentRootPage()
    {
        foreach ($this->listRootPages() as $page) {
            if ($page->isCurrent()) {
                return $page;
            }
            if ($page->isParentOfCurrent()) {
                return $page;
            }
        }
    }


}
