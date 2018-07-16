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

class Server
{
    protected $configFile = null;

    /**
     * Constructor.
     */
    public function __construct($configFile)
    {
        $this->configFile = $configFile;
        $this->configData = json_decode(file_get_contents($configFile), true);

        $this->templatesDir = dirname($configFile) . '/templates';
    }

    public function run()
    {
        $pageClass = $this->getRoutePageClass();

        $page = new $pageClass($this);

        return $page->render();
    }

    public function getRouteTokens()
    {
        $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!preg_match('/\.html$/i', $route)) {
            return ['404'];
        }

        return explode('/', substr($route, 1, strlen($route) - 6));
    }

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

        return '404';
    }

    public function getClassName($class)
    {
        if (isset($this->configData['namespace']) && $this->configData['namespace']) {
            return trim($this->configData['namespace'], '\\') . '\\' . trim($class, '\\');
        }

        return trim($class, '\\');
    }

    public function getLayoutFile($name)
    {
        return $this->templatesDir . '/' . $name;
    }
}
