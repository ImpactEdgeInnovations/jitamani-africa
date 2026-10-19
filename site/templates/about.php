<?php snippet('header') ?>
<section class="about-intro wrap">
  <div class="about-copy"><p class="eyebrow">About us</p><h1><?= $page->headline()->esc() ?><br><span class="accent"><?= $page->headlineaccent()->esc() ?></span></h1><p class="lead"><?= $page->intro()->esc() ?></p></div>
  <figure><?php ja_image($page->featureimage()->toFile() ?? $site->file('dining.png'), '(min-width: 900px) 45vw, 100vw', true); ?><figcaption>From our event archive / The Chef and The Cook</figcaption></figure>
</section>
<section class="about-story wrap"><div><div class="story-intro"><?= $page->text()->kirbytext() ?></div><div class="approach-columns"><div><h2><?= $page->thinkingheading()->esc() ?></h2><p><?= $page->thinkingtext()->esc() ?></p></div><div><h2><?= $page->workingheading()->esc() ?></h2><p><?= $page->workingtext()->esc() ?></p></div></div><a class="text-link" href="<?= page('services')->url() ?>">Discover our services <?= ja_icon('diagonal') ?></a></div></section>
<?php snippet('brands') ?>
<?php snippet('invitation') ?>
<?php snippet('footer') ?>
