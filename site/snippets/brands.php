<?php
$home = page('home');
$brands = $home->brands()->toStructure()->filter(fn ($brand) => $brand->visible()->isEmpty() || $brand->visible()->toBool());
if ($brands->isEmpty()) return;
$brandItems = array_values(iterator_to_array($brands));
$split = (int) ceil(count($brandItems) / 2);
$rows = [
  array_slice($brandItems, 0, $split),
  array_reverse(array_slice($brandItems, $split)),
];
?>
<section class="brand-strip wrap" id="brands" aria-labelledby="brands-title" data-brand-strip style="--brand-duration:<?= max(52, $brands->count() * 3) ?>s">
  <div class="brand-strip-heading">
    <h2 id="brands-title"><?= $home->brandsheading()->esc() ?></h2>
    <button class="brand-motion-toggle" type="button" aria-pressed="false" hidden>Pause logos</button>
  </div>
  <div class="brand-deck">
    <?php foreach ($rows as $rowIndex => $row): if (!$row) continue; ?>
    <div class="brand-viewport brand-viewport--<?= $rowIndex ? 'reverse' : 'forward' ?>" tabindex="0" role="region" data-brand-viewport aria-label="Brands and collaborators, row <?= $rowIndex + 1 ?> of <?= count($rows) ?>; scroll horizontally to explore">
      <div class="brand-track">
        <?php foreach ([false, true] as $duplicate): ?>
        <ul class="brand-list" role="list"<?= $duplicate ? ' aria-hidden="true" hidden' : '' ?>>
          <?php foreach ($row as $brand):
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
    <?php endforeach ?>
  </div>
</section>
