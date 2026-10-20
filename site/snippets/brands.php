<?php
$home = page('home');
$brands = $home->brands()->toStructure()->filter(fn ($brand) => $brand->visible()->isEmpty() || $brand->visible()->toBool());
if ($brands->isEmpty()) return;
?>
<section class="brand-strip wrap" id="brands" aria-labelledby="brands-title" data-brand-strip style="--brand-duration:<?= max(30, $brands->count() * 6) ?>s">
  <div class="brand-strip-heading">
    <h2 id="brands-title"><?= $home->brandsheading()->esc() ?></h2>
    <button class="brand-motion-toggle" type="button" aria-pressed="false" hidden>Pause logos</button>
  </div>
  <div class="brand-viewport" tabindex="0" role="region" aria-label="Brands and collaborators; scroll horizontally to explore">
    <div class="brand-track">
      <?php foreach ([false, true] as $duplicate): ?>
      <ul class="brand-list" role="list"<?= $duplicate ? ' aria-hidden="true" hidden' : '' ?>>
        <?php foreach ($brands as $brand):
          $logo = $brand->logo()->toFile();
          $shape = $logo ? ($logo->ratio() < 1.2 ? 'compact' : ($logo->ratio() > 3 ? 'wide' : 'standard')) : 'name';
        ?>
        <li class="brand-logo brand-logo--<?= $shape ?><?= $logo && $brand->dark()->toBool() ? ' brand-logo--white-art' : '' ?>">
          <?php if ($logo): ?><img src="<?= $logo->url() ?>" alt="<?= $brand->name()->esc() ?>" width="<?= $logo->width() ?>" height="<?= $logo->height() ?>" loading="lazy" decoding="async"><?php else: ?><span class="brand-name"><?= $brand->name()->esc() ?></span><?php endif ?>
        </li>
        <?php endforeach ?>
      </ul>
      <?php endforeach ?>
    </div>
  </div>
</section>
