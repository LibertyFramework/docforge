<?php
/**
 *
 */

$context = $this->getContext();
?>

<nav>
    <div class="nav-container">
        <div class="nav-logo">
            <a href="/"><?=$context->getName()?></a>
        </div>
        <ul class="nav-links">
            <?php foreach ($context->listRootPages() as $page) { ?>
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
