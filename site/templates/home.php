<?php snippet('header') ?>
<section class="home-intro wrap">
  <p class="eyebrow"><?= $page->eyebrow()->esc() ?></p>
  <h1><?= $page->headline()->esc() ?><br><?= $page->headlinesecond()->esc() ?> <span class="accent"><?= $page->headlineaccent()->esc() ?></span></h1>
  <div class="hero-bottom"><p class="hero-description"><?= $page->intro()->esc() ?></p><div class="hero-actions"><a class="button" href="<?= page('contact')->url() ?>">Start a conversation <?= ja_icon('diagonal') ?></a><a class="text-link" href="<?= page('work')->url() ?>">View our work <?= ja_icon('diagonal') ?></a></div></div>
</section>
<figure class="home-hero-photo wrap">
  <?php ja_image($page->heroimage()->toFile() ?? $site->heroimage()->toFile() ?? $site->image(), '(min-width: 1440px) 1328px, 94vw', true); ?>
  <figcaption><span><?= $page->herocaption()->esc() ?></span><span aria-hidden="true">01 / A shared experience</span></figcaption>
</figure>
<section class="selected-work wrap" aria-labelledby="selected-work-title">
  <div class="section-heading"><div><p class="eyebrow">Selected work</p><h2 id="selected-work-title"><?= $page->workheading()->esc() ?></h2></div><a class="text-link" href="<?= page('work')->url() ?>">Explore our work <?= ja_icon('diagonal') ?></a></div>
  <div class="home-work-grid">
    <?php $cocktail = page('work/cocktail-takeover'); ?>
    <figure><a href="<?= $cocktail->url() ?>"><?php ja_image($site->file('cocktail.jpeg'), '(min-width: 900px) 580px, 100vw'); ?></a><figcaption>Cocktail takeover / From the existing archive</figcaption></figure>
    <figure><a href="<?= $cocktail->url() ?>"><?php ja_image($site->file('mixologist.jpeg'), '(min-width: 900px) 580px, 100vw'); ?></a><figcaption>A closer look / From the existing archive</figcaption></figure>
  </div>
</section>
<section class="home-services wrap" aria-label="Our services">
  <div class="service-index"><?php foreach (ja_services() as $service): ?><a href="<?= page('services')->url() ?>#<?= $service->slug()->esc() ?>"><span><?= $service->title()->esc() ?></span><?= ja_icon() ?></a><?php endforeach ?></div>
</section>
<?php snippet('invitation') ?>
<?php snippet('footer') ?>
