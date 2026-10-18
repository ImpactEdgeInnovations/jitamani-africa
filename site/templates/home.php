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
  <div class="project-grid">
    <?php foreach (page('work')->children()->listed()->flip()->limit(2) as $project) snippet('project-preview', compact('project')) ?>
  </div>
</section>
<section class="home-services wrap" aria-labelledby="services-title">
  <div class="services-aside"><p class="eyebrow">What we bring</p><h2 id="services-title"><?= nl2br($page->servicesheading()->esc()) ?></h2><p><?= $page->servicesintro()->esc() ?></p><a class="text-link" href="<?= page('services')->url() ?>">Our services <?= ja_icon('diagonal') ?></a></div>
  <div class="service-index"><?php foreach (ja_services() as $index => $service): ?><a href="<?= page('services')->url() ?>#<?= $service->slug()->esc() ?>"><span class="service-number">0<?= $index + 1 ?></span><span><?= $service->title()->esc() ?></span><?= ja_icon() ?></a><?php endforeach ?></div>
</section>
<?php snippet('invitation') ?>
<?php snippet('footer') ?>
