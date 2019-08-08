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

class Builder extends Context
{
    /**
     *
     */
    public function run()
    {
        foreach ($this->listAllPages() as $page) {
            $pageFile = $this->getBuildPath($page->getFileName());
            if (!is_dir(dirname($pageFile))) {
                mkdir(dirname($pageFile), 0777, true);
            }
            file_put_contents($pageFile, $page->renderize());
        }
    }

    /**
     * @param string $file
     * @return string
     */
    public function getBuildPath($file = '')
    {
        $cwd = getcwd();

        return $cwd.'/build/'.$file;
    }
}
