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
    use Page\PrintTrait;

    /**
     * @var null
     */
    protected $context;

    /**
     * Unique node page identifier.
     *
     * @var string
     */
    protected $node;

    /**
     * Unique slug page identifier.
     *
     * @var string
     */
    protected $slug;

    /**
     * Constructor.
     */
    public function __construct($context, $node, $slug = null)
    {
        if ($slug === null) {
            $slug = $node;
        }

        $this->context = $context;
        $this->node = $node;
        $this->slug = $slug;
        $this->name = $this->node != 'index' ? ucwords(basename($this->node)) : 'Home';
    }

    /**
     * @return null
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function isCurrent()
    {
        return $this->context->isCurrentPage($this);
    }

    /**
     * @return mixed
     */
    public function isParentOfCurrent()
    {
        return $this->context->isParentOfCurrentPage($this);
    }

    /**
     *
     */
    public function hasSubpages()
    {
        return $this->context->hasSubpages($this);
    }

    /**
     *
     */
    public function listSubpages()
    {
        return $this->context->listSubpages($this);
    }

    /**
     *
     */
    public function hasTerminalSubpages()
    {
        return $this->context->hasTerminalSubpages($this);
    }

    /**
     *
     */
    public function listTerminalSubpages()
    {
        return $this->context->listTerminalSubpages($this);
    }

    /**
     *
     */
    public function hasNonterminalSubpages()
    {
        return $this->context->hasNonterminalSubpages($this);
    }

    /**
     *
     */
    public function listNonterminalSubpages()
    {
        return $this->context->listNonterminalSubpages($this);
    }

    /**
     *
     */
    public function content()
    {

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

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->slug.'.html';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return '/'.$this->slug.'.html';
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label ?: $this->name;
    }

    /**
     * @return string
     */
    public function getMenuLabel()
    {
        return $this->menuLabel ?: $this->getLabel();
    }
}
