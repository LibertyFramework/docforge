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
use Webmozart\Glob\Glob;
use Webmozart\PathUtil\Path;

trait PagesTrait
{
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
     *
     */
    public function getConfigSubPagesByNode($node)
    {
        if ($this->hasCache(__METHOD__, $node)) {
            return $this->getCache(__METHOD__, $node);
        }

        $pages = $this->config['pages'];
        foreach (explode('/', $node) as $token) {
            $pages = isset($pages[$token]) ? $pages[$token] : null;
        }

        return $this->setCache(__METHOD__, $node, $pages);
    }

    /**
     * @return array
     */
    public function getPages()
    {
        $pages = [];
        $config = $this->config['pages'];

        if (is_array($config) && $config) {
            foreach ($config as $key => $value) {
                $this->fillPagesArray($pages, $key, $value);
            }
        } else {
            $this->fillPagesArray($pages, 0, $config);
        }

        if (isset($_GET['debug_pages']) && $_GET['debug_pages']) {
            echo '<pre>';
            var_dump($pages);
            echo '</pre>';
            exit;
        }

        return $pages;
    }

    /**
     *
     */
    public function fillPagesArray(&$pages, $key, $value)
    {
        if (is_int($key) && Functions::isGlob($value)) {
            return $pages = array_merge($pages, $this->getPagesByGlob($value));
        } elseif (Functions::isSlug($key) && Functions::isGlob($value)) {
            return $pages = array_merge($pages, [$key => $this->getPagesByGlob($value)]);
        } elseif (Functions::isSlug($key) && $this->isClassName($value)) {
            return $pages = array_merge($pages, [$key => $this->getClassName($value)]);
        }

        die('Error on "pages" block at: '.json_encode([$key => $value]));
    }

    /**
     * @param $glob
     */
    public function getPagesByGlob($glob)
    {
        $base = realpath($this->getSourceDir());
        $offset = strlen($base) + 1;
        $pages = [];
        $paths = Glob::glob(Path::makeAbsolute($glob, $base));

        foreach ($paths as $file) {
            $path = explode('/', dirname(substr($file, $offset)));
            $temp = &$pages;
            foreach ($path as $index => $slug) {
                if ($slug == '.') {
                    $temp[Functions::getFileSlug($file)] = $file;
                    break;
                }
                $temp = &$temp[$slug];
                if (!is_array($temp)) {
                    $temp = [];
                }
                if ($index+1 == count($path)) {
                    $temp[Functions::getFileSlug($file)] = $file;
                }
            }
        }

        return $pages;
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

        if (isset($this->config['pages']) && is_array($this->config['pages'])) {
            foreach ($this->config['pages'] as $key => $item) {
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
        foreach ($this->config['pages'] as $key => $item) {
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

        if (isset($this->config['pages']) && is_array($this->config['pages'])) {
            foreach ($this->config['pages'] as $key => $item) {
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
        foreach ($this->config['pages'] as $key => $item) {
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
    public function hasNonTerminalSubPages($page)
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
    public function listNonTerminalSubpages($page)
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

        return $this->setCache(__METHOD__, $this->buildPagesList($this->config['pages']));
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
        $this->listAllPagesRecursive($this->config['pages'], $pages);

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
}
