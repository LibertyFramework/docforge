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

abstract class Context
{
    use Context\CacheTrait;
    use Context\PagesTrait;
    use Context\TemplatesTrait;

    /**
     * Configuration filename.
     *
     * @var string
     */
    protected $configFile;

    /**
     * @var
     */
    protected $workingDir;

    /**
     * Constructor.
     */
    public function __construct($configFile)
    {
        $this->configFile = $configFile;
        $this->configData = json_decode(file_get_contents($configFile), true);
        $this->workingDir = dirname($configFile);

        $this->templatesDir = dirname($configFile) . '/templates';

        $this->configData['pages'] = $this->sanitizePages($this->configData['pages']);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->configData['name'];
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->configData['author'] ?: 'someone';
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

    /**
     * @param string $path
     * @return string
     */
    public function getWorkingDir($path = '')
    {
        return $this->workingDir.'/'.$path;
    }
}
