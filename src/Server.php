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
        $pageClass = $this->getRoutePageClass();
        $page = new $pageClass($this);

        echo $page->renderize();
    }

    /**
     * @return string
     */
    public function getRoutePageClass()
    {
        $pages = $this->configData['pages'];
        $tokens = $this->getRouteTokens();
        $depth = count($tokens) - 1;
        foreach ($tokens as $index => $token) {
            if (isset($pages[$token]) && $index == $depth && is_string($pages[$token])) {
                return $this->getClassName($pages[$token]);
            } elseif (isset($pages[$token]) && is_array($pages[$token]) && $index < $depth) {
                $pages = $pages[$token];
            }
        }

        return '\\Javanile\\Elegy\\Page404';
    }

    /**
     * Get browser URL tokens for routing.
     *
     * @return array
     */
    public function getRouteTokens()
    {
        $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!preg_match('/\.html$/i', $route)) {
            return ['404'];
        }

        return explode('/', substr($route, 1, strlen($route) - 6));
    }
}
