<?php
$home = page('home');
$featured = $featured ?? false;
$brands = $home->brands()->toStructure();
if ($featured) $brands = $brands->filter(fn ($brand) => $brand->featured()->toBool())->limit(6);
if ($brands->isEmpty()) return;
?>
<section class="brand-section wrap<?= $featured ? ' brand-section--featured' : '' ?>" id="brands" aria-labelledby="brands-title">
  <div class="brand-section-heading">
    <h2 id="brands-title"><?= $featured ? $home->brandsheading()->esc() : 'Brands and collaborators' ?></h2>
    <?php if ($featured): ?><a class="text-link" href="<?= page('about')->url() ?>#brands">More brands and collaborators <?= ja_icon('diagonal') ?></a><?php endif ?>
  </div>
  <ul class="brand-grid" role="list">
    <?php foreach ($brands as $brand): $logo = $brand->logo()->toFile(); ?>
    <li><figure>
      <div class="brand-logo<?= $logo && $brand->dark()->toBool() ? ' brand-logo--dark' : '' ?>">
        <?php if ($logo): ?><img src="<?= $logo->url() ?>" alt="<?= $brand->name()->esc() ?>" width="<?= $logo->width() ?>" height="<?= $logo->height() ?>" loading="lazy" decoding="async"><?php else: ?><span class="brand-name"><?= $brand->name()->esc() ?></span><?php endif ?>
      </div>
      <?php if (!$featured && $logo): ?><figcaption><?= $brand->name()->esc() ?></figcaption><?php endif ?>
    </figure></li>
    <?php endforeach ?>
  </ul>
</section>
