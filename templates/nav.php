<?php
/**
 *
 */

$scope = $this->getScope();
?>

<nav>
    <div class="nav-container">
        <div class="nav-logo">
            <a href="/">
                <i class="fas fa-scroll"></i>
                <?=$scope->getName()?>
            </a>
            <small>
                This is the payoff
            </small>
        </div>
        <ul class="nav-links">
            <?php foreach ($scope->listRootPages() as $page) { ?>
                <li>
                    <a <?=$page->isCurrent()||$page->isParentOfCurrent()?'class="active"':''?>
                            href="<?=$page->getUrl()?>">
                        <?=$page->getMenuLabel()?>
                    </a>
                </li>
            <?php } ?>
            <li>
                <div class="nav-search">
                    <div class="gcse-searchbox-only"></div>
                </div>
            </li>
        </ul>
    </div>
</nav>
