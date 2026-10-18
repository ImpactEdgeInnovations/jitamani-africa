<?php snippet('header') ?>
<section class="text-page wrap"><p class="eyebrow">Jitamani Africa</p><h1><?= $page->headline()->or($page->title())->esc() ?><span class="accent">.</span></h1><div class="prose"><?= $page->text()->kirbytext() ?></div></section>
<?php snippet('footer') ?>
