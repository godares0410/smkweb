<?php
$pageTitle = $page['title'];
?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1><?= e($page['title']) ?></h1>
                <div class="content mt-4">
                    <?= $page['content'] ?>
                </div>
            </div>
        </div>
    </div>
</section>

