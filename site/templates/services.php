<?php snippet('header') ?>
<section class="page-intro wrap"><p class="eyebrow">Our services</p><h1><?= $page->headline()->esc() ?><br><span class="accent"><?= $page->headlineaccent()->esc() ?></span></h1><p class="lead"><?= $page->intro()->esc() ?></p></section>
<section class="service-list wrap" aria-label="Our four capabilities">
  <?php foreach (ja_services() as $i => $service): ?>
  <article class="service-detail" id="<?= $service->slug()->esc() ?>"><span class="service-number">0<?= $i + 1 ?></span><div class="service-title"><h2><?= $service->title()->esc() ?></h2><p><?= $service->summary()->esc() ?></p></div><div class="service-description"><p><?= $service->audience()->esc() ?></p><ul><?php foreach (explode("\n", $service->activities()->value()) as $activity): ?><li><?= esc($activity) ?></li><?php endforeach ?></ul></div></article>
  <?php endforeach ?>
</section>
<section class="service-contact"><div class="wrap"><p class="eyebrow">Let’s find the right approach</p><h2>Tell us what you need.</h2><a class="light-link" href="<?= page('contact')->url() ?>">Start a conversation <?= ja_icon('diagonal') ?></a></div></section>
<?php snippet('footer') ?>
