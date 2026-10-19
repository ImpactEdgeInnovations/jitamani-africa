<?php snippet('header') ?>
<section class="home-hero" aria-labelledby="home-title">
  <div class="home-hero-inner">
    <div class="home-hero-copy">
      <p class="eyebrow"><?= $page->eyebrow()->esc() ?></p>
      <h1 id="home-title"><?= $page->headline()->esc() ?><br><span class="accent"><?= $page->headlineaccent()->esc() ?></span> <?= $page->headlinesecond()->esc() ?></h1>
      <p class="hero-description"><?= $page->intro()->esc() ?></p>
      <a class="button" href="<?= page('contact')->url() ?>">Start a conversation <?= ja_icon('diagonal') ?></a>
    </div>
    <figure class="home-hero-photo"><?php ja_image($page->heroimage()->toFile() ?? $site->file('mixologist.jpeg'), '(min-width: 1440px) 720px, (min-width: 761px) 50vw, 100vw', true); ?></figure>
  </div>
</section>
<section class="home-introduction wrap" aria-labelledby="introduction-title">
  <p class="eyebrow">Meet Jitamani</p>
  <div><h2 id="introduction-title"><?= $page->introductionheading()->esc() ?></h2><p><?= $page->introductiontext()->esc() ?></p><p class="sector-line"><span class="eyebrow">Across sectors</span><?= $page->sectors()->esc() ?></p><a class="text-link" href="<?= page('about')->url() ?>">More about us <?= ja_icon('diagonal') ?></a></div>
</section>
<section class="selected-work wrap" aria-labelledby="selected-work-title">
  <div class="section-heading"><div><p class="eyebrow">Events & experiences</p><h2 id="selected-work-title"><?= $page->workheading()->esc() ?></h2></div><a class="text-link" href="<?= page('work')->url() ?>">View all work <?= ja_icon('diagonal') ?></a></div>
  <div class="project-grid"><?php foreach (ja_events()->limit(2) as $project) snippet('project-preview', compact('project')) ?></div>
</section>
<section class="home-digital wrap" aria-labelledby="digital-work-title">
  <div><p class="eyebrow">Another part of our work</p><h2 id="digital-work-title">Digital platforms, built with purpose.</h2><p>Our AI and technology capabilities include platforms developed for business and community.</p></div>
  <div class="digital-project-links"><?php foreach (ja_platforms() as $project): ?><a href="<?= $project->url() ?>"><?= $project->title()->esc() ?> <?= ja_icon('diagonal') ?></a><?php endforeach ?><a class="text-link" href="<?= page('work')->url() ?>#platforms">Explore our digital work <?= ja_icon('diagonal') ?></a></div>
</section>
<section class="home-services wrap" aria-labelledby="home-services-title">
  <h2 class="eyebrow" id="home-services-title">How we can help</h2>
  <div class="service-index"><?php foreach (ja_services() as $i => $service): ?><a href="<?= page('services')->url() ?>#<?= $service->slug()->esc() ?>"><span class="service-number">0<?= $i + 1 ?></span><span><?= $service->title()->esc() ?></span><?= ja_icon() ?></a><?php endforeach ?></div>
</section>
<?php snippet('invitation') ?>
<?php snippet('footer') ?>
