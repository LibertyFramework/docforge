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

class Server extends Context
{
    /**
     * Rederize page by server routing.
     */
    public function run()
    {
        if (empty($this->configData['pages'])) {
            die('Empty "pages" into elegy.json');
        }

        $page = $this->getRoutePage();

        echo $page->renderize();
    }

    /**
     * @return string
     */
    public function getRoutePage()
    {
        $pages = $this->configData['pages'];
        $slug = $this->getRouteSlug();
        $tokens = $this->getTokensBySlug($slug);
        $depth = count($tokens) - 1;

        foreach ($tokens as $index => $token) {
            if (isset($pages[$token]) && $index == $depth && is_string($pages[$token])) {
                $pageClass = $this->getClassName($pages[$token]);
                return new $pageClass($this, $slug);
            } elseif (isset($pages[$token]) && is_array($pages[$token]) && $index < $depth) {
                $pages = $pages[$token];
            }
        }

        $page = new Page404($this, $slug);

        return $page;
    }

    /**
     * Get browser URL tokens for routing.
     *
     * @return array
     */
    public function getRouteSlug()
    {
        $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!preg_match('/\.html$/i', $route)) {
            return '404';
        }

        return substr($route, 1, strlen($route) - 6);
    }

    /**
     * Get browser URL tokens for routing.
     *
     * @return array
     */
    public function getTokensBySlug($slug)
    {
        return explode('/', $slug);
    }
}
