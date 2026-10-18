<?php snippet('header') ?>
<article class="article-layout wrap"><header class="article-heading"><a class="back-link" href="<?= page('blogs')->url() ?>">← From the archive</a><p class="eyebrow"><time datetime="<?= $page->date()->toDate('Y-m-d') ?>"><?= $page->date()->toDate('d F Y') ?></time> / Original story</p><h1><?= $page->title()->esc() ?></h1></header><figure class="article-cover"><?php ja_image($page->cover()->toFile() ?? $page->image(), '90vw', true); ?></figure><div class="prose article-body"><?= $page->text()->kirbytext() ?></div><div class="article-close"><a class="text-link" href="<?= page('work')->url() ?>">Explore our work <?= ja_icon('diagonal') ?></a></div></article>
<?php snippet('invitation') ?>
<?php snippet('footer') ?>
