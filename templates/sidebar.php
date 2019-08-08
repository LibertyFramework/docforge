<?php
/**
 *
 */

$scope = $this->getScope();
$currentRootPage = $scope->getCurrentRootPage();
?>

<div class="sidebar sidebar-left">

    <?php if (!$currentRootPage->hasSubPages()) { ?>
        <?php if ($scope->hasNonTerminalRootPages()) { ?>
            <?php foreach ($scope->listNonTerminalRootPages() as $page) { ?>
                <h3 class="sidebar-category active"><?=$page->getLabel()?></h3>
                <ul class="sidebar-links">
                    <?php foreach ($page->listSubPages() as $subPage) { ?>
                        <li>
                            <a <?=$subPage->isCurrent()?'class="active"':''?> href="<?=$subPage->getUrl()?>">
                                <?=$subPage->getMenuLabel()?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } elseif ($scope->hasTerminalRootPages()) { ?>
            <h3 class="sidebar-category active">Menu</h3>
            <ul class="sidebar-links">
                <?php foreach ($scope->listTerminalRootPages() as $page) { ?>
                    <li>
                        <a <?=$page->isCurrent()?'class="active"':''?> href="<?=$page->getUrl()?>">
                            <?=$page->getMenuLabel()?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    <?php } ?>

    <?php if ($currentRootPage->hasTerminalSubPages()) { ?>
        <h3 class="sidebar-category active"><?=$currentRootPage->getLabel()?></h3>
        <ul class="sidebar-links">
            <?php foreach ($currentRootPage->listTerminalSubPages() as $page) { ?>
                <li>
                    <a <?=$page->isCurrent()?'class="active"':''?> href="<?=$page->getUrl()?>">
                        <?=$page->getMenuLabel()?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

    <?php if ($currentRootPage->hasNonTerminalSubPages()) { ?>
        <?php foreach ($currentRootPage->listNonterminalSubpages() as $page) { ?>
            <h3 class="sidebar-category active"><?=$page->getLabel()?></h3>
            <ul class="sidebar-links">
                <?php foreach ($page->listSubpages() as $subpage) { ?>
                    <li>
                        <a <?=$subpage->isCurrent()?'class="active"':''?> href="<?=$subpage->getUrl()?>">
                            <?=$subpage->getMenuLabel()?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    <?php } ?>

</div>
