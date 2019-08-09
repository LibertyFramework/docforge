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

class Page
{
    use Page\MenuTrait;
    use Page\PrintTrait;

    /**
     * @var null
     */
    protected $scope;

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
    public function __construct($scope, $node, $slug = null)
    {
        if ($slug === null) {
            $slug = $node;
        }

        $this->scope = $scope;
        $this->node = $node;
        $this->slug = $slug;
        $this->name = $this->node != 'index' ? ucwords(basename($this->node)) : 'Home';
    }

    /**
     * @return null
     */
    public function getScope()
    {
        return $this->scope;
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
        return $this->scope->isCurrentPage($this);
    }

    /**
     * @return mixed
     */
    public function isParentOfCurrent()
    {
        return $this->scope->isParentOfCurrentPage($this);
    }

    /**
     *
     */
    public function hasSubpages()
    {
        return $this->scope->hasSubpages($this);
    }

    /**
     *
     */
    public function listSubpages()
    {
        return $this->scope->listSubpages($this);
    }

    /**
     *
     */
    public function hasTerminalSubpages()
    {
        return $this->scope->hasTerminalSubpages($this);
    }

    /**
     *
     */
    public function listTerminalSubpages()
    {
        return $this->scope->listTerminalSubpages($this);
    }

    /**
     *
     */
    public function hasNonterminalSubpages()
    {
        return $this->scope->hasNonterminalSubpages($this);
    }

    /**
     *
     */
    public function listNonterminalSubpages()
    {
        return $this->scope->listNonterminalSubpages($this);
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

        $layoutFile = $this->scope->getTemplateFile('index.php');

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
