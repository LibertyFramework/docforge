<?php
/**
 *
 */

$scope = $this->getScope();
?>

<nav>
    <div class="nav-container">
        <div class="nav-logo">
            <a href="/"><?=$scope->getName()?></a>
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
        </ul>
    </div>
</nav>
