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

abstract class Context
{
    use Context\PagesTrait;

    /**
     * Configuration filename.
     *
     * @var string
     */
    protected $configFile;

    /**
     * Constructor.
     */
    public function __construct($configFile)
    {
        $this->configFile = $configFile;
        $this->configData = json_decode(file_get_contents($configFile), true);

        $this->templatesDir = dirname($configFile) . '/templates';
    }

    /**
     * @return mixed
     */
    public function getConfigName()
    {
        return $this->configData['name'];
    }

    /**
     * @param $class
     * @return string
     */
    public function getClassName($class)
    {
        if (isset($this->configData['namespace']) && $this->configData['namespace']) {
            return trim($this->configData['namespace'], '\\') . '\\' . trim($class, '\\');
        }

        return trim($class, '\\');
    }
}
