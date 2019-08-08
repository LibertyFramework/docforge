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

namespace Javanile\DocForge;

abstract class Scope
{
    use Scope\CacheTrait;
    use Scope\PageTrait;
    use Scope\PagesTrait;
    use Scope\TemplatesTrait;

    /**
     * Configuration filename.
     *
     * @var string
     */
    protected $configFile;

    /**
     * Configuration filename.
     *
     * @var string
     */
    protected $config;

    /**
     * @var
     */
    protected $workingDir;

    /**
     * @var
     */
    protected $templatesDir;

    /**
     * Constructor.
     *
     * @param $configFile
     */
    public function __construct($configFile)
    {
        $this->configFile = $configFile;
        $this->config = json_decode(file_get_contents($configFile), true);
        $this->workingDir = dirname($configFile);

        $this->templatesDir = dirname($configFile) . '/templates';
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return isset($this->config['name']) ? $this->config['name'] : 'docforge';
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->config['author'] ?: 'someone';
    }

    /**
     * @param $class
     * @return string
     */
    public function getClassName($class)
    {
        if (isset($this->config['namespace']) && $this->config['namespace']) {
            return trim($this->config['namespace'], '\\') . '\\' . trim($class, '\\');
        }

        return trim($class, '\\');
    }

    /**
     * @param $class
     * @return string
     */
    public function isClassName($class)
    {
        return class_exists($this->getClassName($class));
    }

    /**
     * @param string $path
     * @return string
     */
    public function getWorkingDir($path = '')
    {
        return $this->workingDir.'/'.$path;
    }

    /**
     * @param string $path
     * @return string
     */
    public function getSourceDir()
    {
        return isset($this->config['source']) ? $this->workingDir.'/'.$this->config['source'] : $this->workingDir;
    }
}
