<?php
$widths = array_unique(array_merge(array_filter([480, 800, 1200, 1600], fn ($width) => $width < $file->width()), [min(1600, $file->width())]));
$variants = [];
foreach ($widths as $width) $variants[$width . 'w'] = ['width' => $width, 'format' => 'webp'];
$src = $file->thumb(['width' => min(1600, $file->width()), 'format' => 'webp']);
?><img class="<?= esc($class, 'attr') ?>" src="<?= esc($src->url(), 'attr') ?>" srcset="<?= esc($file->srcset($variants), 'attr') ?>" sizes="<?= esc($sizes, 'attr') ?>" width="<?= $file->width() ?>" height="<?= $file->height() ?>" alt="<?= esc($file->alt()->or($file->name())->value(), 'attr') ?>" loading="<?= $priority ? 'eager' : 'lazy' ?>" decoding="async"<?= $priority ? ' fetchpriority="high"' : '' ?>>
