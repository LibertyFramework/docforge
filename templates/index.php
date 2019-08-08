<?php
/**
 *
 */

include __DIR__.'/header.php';
include __DIR__.'/nav.php';
?>

<main>
    <div class="container">
        <div class="row row-reverse">
            <div class="col col-lg-9 mt0 pt0">
                <section class="mt0 pt0">
                    <?php $this->content() ?>
                </section>
            </div>
            <div class="col col-lg-3 display-lg-up">
                <?php include __DIR__.'/sidebar.php' ?>
            </div>
        </div>
    </div>
</main>

<?php
include __DIR__ . '/footer.php';
