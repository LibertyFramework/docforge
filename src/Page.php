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
    use Page\MenuTrait;
    use Page\RenderTrait;

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
