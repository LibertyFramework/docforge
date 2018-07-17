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
    protected $context = null;

    /**
     * Constructor.
     */
    public function __construct($context)
    {
        $this->context = $context;
    }

    /**
     *
     */
    public function renderize()
    {
        $layoutFile = $this->context->getLayoutFile('index.php');

        include $layoutFile;
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
}
