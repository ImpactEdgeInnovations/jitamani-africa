<?php snippet('header'); $cover = $page->cover()->toFile() ?? $page->image(); $platform = $page->worktype()->value() === 'platform'; ?>
<section class="project-intro wrap"><a class="back-link" href="<?= page('work')->url() ?>">← Our work</a><p class="eyebrow"><?= $page->category()->esc() ?> / <?= $page->location()->esc() ?></p><h1><?= $page->title()->esc() ?><span class="accent">.</span></h1><p class="lead"><?= $page->intro()->esc() ?></p><?php if ($page->role()->isNotEmpty()): ?><div class="project-role"><h2 class="eyebrow">Jitamani’s role</h2><p><?= $page->role()->esc() ?></p></div><?php endif ?></section>
<?php if ($platform): ?><div class="platform-project-hero wrap"><?php snippet('platform-art', ['project' => $page]) ?><?php if ($external = ja_platform_url($page)): ?><a class="text-link" href="<?= esc($external, 'attr') ?>" target="_blank" rel="noopener noreferrer">Visit <?= $page->title()->esc() ?> <?= ja_icon('diagonal') ?></a><?php endif ?></div><?php else: ?><figure class="project-hero wrap"><?php ja_image($cover, '94vw', true); ?><figcaption><?= $page->caption()->esc() ?></figcaption></figure><?php endif ?>
<section class="project-story wrap"><p class="eyebrow"><?= $platform ? 'The platform' : 'The experience' ?></p><div class="prose"><?= $page->text()->kirbytext() ?><?php if ($archive = page($page->archive()->value())): ?><a class="text-link" href="<?= $archive->url() ?>">Read the original story <?= ja_icon('diagonal') ?></a><?php endif ?></div></section>
<?php if ($page->brief()->isNotEmpty() || $page->delivery()->isNotEmpty() || $page->outcome()->isNotEmpty()): ?>
<section class="case-study wrap" aria-label="Project details">
  <?php foreach (['brief' => 'The idea', 'delivery' => ($platform ? 'What we developed' : 'The experience in detail'), 'outcome' => 'The outcome'] as $field => $label): if ($page->$field()->isEmpty()) continue; ?>
  <div class="case-study-row"><h2><?= $label ?></h2><div class="prose"><?= $page->$field()->kirbytext() ?></div></div>
  <?php endforeach ?>
</section>
<?php endif ?>
<?php if ($page->gallery()->toFiles()->count()): ?><section class="project-gallery wrap" aria-label="Photographs from the experience"><?php foreach ($page->gallery()->toFiles() as $photo): if ($photo->id() === $cover?->id()) continue; ?><figure><?php ja_image($photo, '(min-width: 900px) 65vw, 100vw'); ?><figcaption><?= $photo->alt()->esc() ?></figcaption></figure><?php endforeach ?></section><?php endif ?>
<?php $next = $page->nextListed() ?? page('work')->children()->listed()->first(); if ($next && !$next->is($page)): ?><div class="next-project wrap"><span class="eyebrow">Next story</span><a href="<?= $next->url() ?>"><?= $next->title()->esc() ?> <?= ja_icon('diagonal') ?></a></div><?php endif ?>
<?php snippet('invitation') ?>
<?php snippet('footer') ?>
