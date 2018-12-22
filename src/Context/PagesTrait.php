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

trait PagesTrait
{
    /**
     *
     */
    public function sanitizeSlug($slug)
    {
        return $slug;
    }

    /**
     *
     */
    public function sanitizePages($pages)
    {
        return $pages;
    }

    /**
     *
     */
    public function buildPage($item, $slug)
    {
        $pageClass = $this->getClassName($item);
        if (!class_exists($pageClass)) {
            $pageClass = Page::class;
        }

        return new $pageClass($this, $slug);
    }

    /**
     *
     */
    public function buildPagesList($pages)
    {
        $pagesList = [];

        foreach ($pages as $id => $item) {
            if (is_array($item)) {
                $item = Functions::getArrayFirstValueRecursive($item);
            }

            $pagesList[] = $this->buildPage($item, $id);
        }

        return $pagesList;
    }

    /**
     *
     */
    public function getConfigSubpagesBySlug($slug)
    {
        if ($this->hasCache(__METHOD__, $slug)) {
            return $this->getCache(__METHOD__, $slug);
        }

        $pages = $this->configData['pages'];
        foreach (explode('/', $slug) as $token) {
            $pages = $pages[$token];
        }

        return $this->setCache(__METHOD__, $slug, $pages);
    }

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
     * @param $page
     * @return bool
     */
    public function isParentOfCurrentPage($page)
    {
        return $this->currentPage->getSlug() == $page->getSlug();
    }

    /**
     * Check if exists one or more terminal root page.
     *
     * @param $page
     * @return bool
     */
    public function hasTerminalRootPages()
    {
        if ($this->hasCache(__METHOD__)) {
            return $this->getCache(__METHOD__);
        }

        foreach ($this->configData['pages'] as $key => $item) {
            if (!is_array($item)) {
                return $this->setCache(__METHOD__, true);
            }
        }

        return $this->setCache(__METHOD__, false);
    }

    /**
     * Check if exists one or more terminal root page.
     *
     * @param $page
     * @return bool
     */
    public function listTerminalRootPages()
    {
        if ($this->hasCache(__METHOD__)) {
            return $this->getCache(__METHOD__);
        }

        $pages = [];
        foreach ($this->configData['pages'] as $key => $item) {
            if (!is_array($item)) {
                $pages[$key] = $item;
            }
        }

        return $this->setCache(__METHOD__, $this->buildPagesList($pages));
    }

    /**
     * Check if exists one or more terminal root page.
     *
     * @param $page
     * @return bool
     */
    public function hasNonterminalRootPages()
    {
        if ($this->hasCache(__METHOD__)) {
            return $this->getCache(__METHOD__);
        }

        foreach ($this->configData['pages'] as $key => $item) {
            if (is_array($item)) {
                return $this->setCache(__METHOD__, true);
            }
        }

        return $this->setCache(__METHOD__, false);
    }

    /**
     * Check if exists one or more terminal root page.
     *
     * @param $page
     * @return bool
     */
    public function listNonterminalRootPages()
    {
        if ($this->hasCache(__METHOD__)) {
            return $this->getCache(__METHOD__);
        }

        $pages = [];
        foreach ($this->configData['pages'] as $key => $item) {
            if (is_array($item)) {
                $pages[$key] = $item;
            }
        }

        return $this->setCache(__METHOD__, $this->buildPagesList($pages));
    }

    /**
     * @param $page
     * @return bool
     */
    public function hasSubpages($page)
    {
        $slug = $page->getSlug();
        if ($this->hasCache(__METHOD__, $slug)) {
            return $this->getCache(__METHOD__, $slug);
        }

        return $this->setCache(
            __METHOD__,
            $slug,
            is_array($this->getConfigSubpagesBySlug($slug))
        );
    }

    /**
     * @param $page
     * @return bool
     */
    public function listSubpages($page)
    {
        $slug = $page->getSlug();
        if ($this->hasCache(__METHOD__, $slug)) {
            return $this->getCache(__METHOD__, $slug);
        }

        $pages = $this->getConfigSubpagesBySlug($slug);
        if (!is_array($pages)) {
            return $this->setCache(__METHOD__, $slug, []);
        }

        return $this->setCache(
            __METHOD__,
            $slug,
            $this->buildPagesList($pages)
        );
    }

    /**
     * @param $page
     * @return bool
     */
    public function hasTerminalSubpages($page)
    {
        $slug = $page->getSlug();
        if ($this->hasCache(__METHOD__, $slug)) {
            return $this->getCache(__METHOD__, $slug);
        }

        foreach ($this->getConfigSubpagesBySlug($slug) as $key => $item) {
            if (!is_array($item)) {
                return $this->setCache(__METHOD__, $slug, true);
            }
        }

        return $this->setCache(__METHOD__, $slug, false);
    }

    /**
     * @param $page
     * @return bool
     */
    public function listTerminalSubpages($page)
    {
        $slug = $page->getSlug();
        if ($this->hasCache(__METHOD__, $slug)) {
            return $this->getCache(__METHOD__, $slug);
        }

        $pages = [];
        foreach ($this->getConfigSubpagesBySlug($slug) as $key => $item) {
            if (!is_array($item)) {
                $pages[$key] = $item;
            }
        }

        return $this->setCache(__METHOD__, $slug, $this->buildPagesList($pages));
    }

    /**
     * @param $page
     * @return bool
     */
    public function hasNonterminalSubpages($page)
    {
        $slug = $page->getSlug();
        if ($this->hasCache(__METHOD__, $slug)) {
            return $this->getCache(__METHOD__, $slug);
        }

        foreach ($this->getConfigSubpagesBySlug($slug) as $key => $item) {
            if (is_array($item)) {
                return $this->setCache(__METHOD__, $slug, true);
            }
        }

        return $this->setCache(__METHOD__, $slug, false);
    }

    /**
     * @param $page
     * @return bool
     */
    public function listNonterminalSubpages($page)
    {
        $slug = $page->getSlug();
        if ($this->hasCache(__METHOD__, $slug)) {
            return $this->getCache(__METHOD__, $slug);
        }

        $pages = [];
        foreach ($this->getConfigSubpagesBySlug($slug) as $key => $item) {
            if (is_array($item)) {
                $pages[$key] = $item;
            }
        }

        return $this->setCache(__METHOD__, $slug, $this->buildPagesList($pages));
    }

    /**
     * @return array
     */
    public function listRootPages()
    {
        if ($this->hasCache(__METHOD__)) {
            return $this->getCache(__METHOD__);
        }

        return $this->setCache(__METHOD__, $this->buildPagesList($this->configData['pages']));
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
