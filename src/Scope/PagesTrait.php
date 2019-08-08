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

namespace Javanile\DocForge\Scope;

use Javanile\DocForge\Functions;
use Javanile\DocForge\Page;
use Javanile\DocForge\Page404;

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
    public function buildPage($item, $node, $slug = null)
    {
        $pageClass = $this->getClassName($item);
        if (!class_exists($pageClass)) {
            $pageClass = Page::class;
        }

        return new $pageClass($this, $node, $slug);
    }

    /**
     *
     */
    public function buildPagesList($pages, $base = '')
    {
        $pagesList = [];

        if (is_array($pages) && $pages) {
            foreach ($pages as $node => $item) {
                $slug = $node;
                if (is_array($item)) {
                    $item = static::getFirstPageRecursive($item, $slug);
                }

                $pagesList[] = $this->buildPage(
                    $item,
                    $base ? $base.'/'.$node : $node,
                    $base ? $base.'/'.$slug : $slug
                );
            }
        }

        return $pagesList;
    }

    /**
     * @param $array
     * @return mixed
     */
    public static function getFirstPageRecursive($pages, &$slug)
    {
        if (!is_array($pages)) {
            return $pages;
        }

        $firstValue = array_pop(array_reverse($pages));
        $firstKey = array_keys($pages)[0];
        $slug = $slug.'/'.$firstKey;

        if (is_array($firstValue)) {
            return static::getFirstPageRecursive($firstValue, $slug);
        }

        return $firstValue;
    }

    /**
     *
     */
    public function getConfigSubpagesByNode($node)
    {
        if ($this->hasCache(__METHOD__, $node)) {
            return $this->getCache(__METHOD__, $node);
        }

        $pages = $this->configData['pages'];
        foreach (explode('/', $node) as $token) {
            $pages = isset($pages[$token]) ? $pages[$token] : null;
        }

        return $this->setCache(__METHOD__, $node, $pages);
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


    public function getPages()
    {
        return $this->configData['name'];
    }

public function getPage404($slug  = '404')
{
    return new Page404($this, $slug);
}

    /**
     * @param $page
     * @return bool
     */
    public function isCurrentPage($page)
    {
        return $this->currentPage->getSlug() == $page->getSlug()
            || $this->currentPage->getNode() == $page->getNode();
    }

    /**
     * Check if page is parent of current page.
     *
     * @param $page
     * @return bool
     */
    public function isParentOfCurrentPage($page)
    {
        $node = $page->getNode().'/';
        $currentNode = $this->currentPage->getNode();
        $currentNodeCut = substr($currentNode, 0, strlen($node));

        return $node == $currentNodeCut;
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

        if (isset($this->configData['pages']) && is_array($this->configData['pages'])) {
            foreach ($this->configData['pages'] as $key => $item) {
                if (!is_array($item)) {
                    return $this->setCache(__METHOD__, true);
                }
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
    public function hasNonTerminalRootPages()
    {
        if ($this->hasCache(__METHOD__)) {
            return $this->getCache(__METHOD__);
        }

        if (isset($this->configData['pages']) && is_array($this->configData['pages'])) {
            foreach ($this->configData['pages'] as $key => $item) {
                if (is_array($item)) {
                    return $this->setCache(__METHOD__, true);
                }
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
    public function listNonTerminalRootPages()
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

        //echo '<pre>';
        //var_dump($pages);
        //echo '</pre>';
        return $this->setCache(__METHOD__, $this->buildPagesList($pages));
    }

    /**
     * @param $page
     * @return bool
     */
    public function hasSubPages($page)
    {
        $node = $page->getNode();
        if ($this->hasCache(__METHOD__, $node)) {
            return $this->getCache(__METHOD__, $node);
        }

        return $this->setCache(__METHOD__, $node, is_array($this->getConfigSubpagesByNode($node)));
    }

    /**
     * @param $page
     * @return bool
     */
    public function listSubPages($page)
    {
        $node = $page->getNode();
        if ($this->hasCache(__METHOD__, $node)) {
            return $this->getCache(__METHOD__, $node);
        }

        $pages = $this->getConfigSubPagesByNode($node);
        if (!is_array($pages)) {
            return $this->setCache(__METHOD__, $node, []);
        }

        return $this->setCache(__METHOD__, $node, $this->buildPagesList($pages, $node));
    }

    /**
     * @param $page
     * @return bool
     */
    public function hasTerminalSubPages($page)
    {
        $node = $page->getNode();
        if ($this->hasCache(__METHOD__, $node)) {
            return $this->getCache(__METHOD__, $node);
        }

        $subpages = $this->getConfigSubPagesByNode($node);
        if (is_array($subpages)) {
            foreach ($subpages as $key => $item) {
                if (!is_array($item)) {
                    return $this->setCache(__METHOD__, $node, true);
                }
            }
        }

        return $this->setCache(__METHOD__, $node, false);
    }

    /**
     * @param $page
     * @return bool
     */
    public function listTerminalSubPages($page)
    {
        $node = $page->getNode();
        if ($this->hasCache(__METHOD__, $node)) {
            return $this->getCache(__METHOD__, $node);
        }

        $pages = [];
        $subpages = $this->getConfigSubpagesByNode($node);
        if (is_array($subpages)) {
            foreach ($subpages as $key => $item) {
                if (!is_array($item)) {
                    $pages[$key] = $item;
                }
            }
        }

        return $this->setCache(__METHOD__, $node, $this->buildPagesList($pages, $node));
    }

    /**
     * @param $page
     * @return bool
     */
    public function hasNonterminalSubpages($page)
    {
        $node = $page->getNode();
        if ($this->hasCache(__METHOD__, $node)) {
            return $this->getCache(__METHOD__, $node);
        }

        $subpages = $this->getConfigSubpagesByNode($node);
        if (is_array($subpages)) {
            foreach ($subpages as $key => $item) {
                if (is_array($item)) {
                    return $this->setCache(__METHOD__, $node, true);
                }
            }
        }

        return $this->setCache(__METHOD__, $node, false);
    }

    /**
     * @param $page
     * @return bool
     */
    public function listNonterminalSubpages($page)
    {
        $node = $page->getNode();
        if ($this->hasCache(__METHOD__, $node)) {
            return $this->getCache(__METHOD__, $node);
        }

        $pages = [];
        $subpages = $this->getConfigSubpagesByNode($node);
        if (is_array($subpages)) {
            foreach ($subpages as $key => $item) {
                if (is_array($item)) {
                    $pages[$key] = $item;
                }
            }
        }

        return $this->setCache(__METHOD__, $node, $this->buildPagesList($pages, $node));
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
        if ($this->hasCache(__METHOD__)) {
            return $this->getCache(__METHOD__);
        }

        $pages = [];
        $this->listAllPagesRecursive($this->configData['pages'], $pages);

        return $this->setCache(__METHOD__, $pages);
    }

    /**
     * @param $struct
     * @param $pages
     */
    public function listAllPagesRecursive($struct, &$pages, $base = '')
    {
        foreach ($struct as $key => $item) {
            if (is_array($item)) {
                $this->listAllPagesRecursive($item, $pages, $base.$id.'/');
            } else {
                $pages[] = $this->buildPage($item, $base.$id);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getCurrentRootPage()
    {
        foreach ($this->listRootPages() as $page) {
            if ($this->isCurrentPage($page)) {
                return $page;
            }
            if ($this->isParentOfCurrentPage($page)) {
                return $page;
            }
        }

        return new Page404($this, '404');
    }
}
