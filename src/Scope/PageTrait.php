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

trait PageTrait
{
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

    /**
     * @param string $slug
     * @return Page404
     */
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
