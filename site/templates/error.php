<?php snippet('header') ?>
<section class="page-intro error-page wrap"><p class="eyebrow">404 / Page not found</p><h1><?= $page->headline()->esc() ?><br><span class="accent"><?= $page->headlineaccent()->esc() ?></span></h1><p class="lead"><?= $page->intro()->esc() ?></p><a class="button" href="<?= page('work')->url() ?>">Explore our work <?= ja_icon('diagonal') ?></a></section>
<?php snippet('footer') ?>
