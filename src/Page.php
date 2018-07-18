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

class Page
{
    /**
     * @var null
     */
    protected $context;

    /**
     * Unique slug page identifier.
     *
     * @var string
     */
    protected $slug;

    /**
     * Constructor.
     */
    public function __construct($context, $slug)
    {
        $this->context = $context;
        $this->slug = $slug;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function isCurrent()
    {
        return false;
    }

    /**
     *
     */
    public function renderize()
    {
        ob_start();

        $layoutFile = $this->context->getTemplateFile('index.php');

        include $layoutFile;

        $html = ob_get_clean();

        return $html;
    }

    public function renderClass($class)
    {
        $reflector = new \ReflectionClass($class);
        $file = $reflector->getFileName();
        $code = file_get_contents($file);

        echo '<pre><code class="php">';
        echo htmlentities(trim(str_replace('<?php', '', $code)));
        echo '</code></pre>';
    }

    public function renderFileBlock($file, $block)
    {
        $code = file_get_contents($file);

        if (preg_match('#//@block:start\('.$block.'\)(.*)//@block:end#is', $code, $matchs)) {
            echo '<pre><code class="php">';
            echo htmlentities(trim($matchs[1]));
            echo '</code></pre>';
        }
    }

    public function getFileName()
    {
        return $this->slug.'.html';
    }

    public function getUrl()
    {
        return '/'.$this->slug.'.html';
    }

    public function getMenuLabel()
    {
        return $this->slug;
    }
}
