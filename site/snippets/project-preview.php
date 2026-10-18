<?php $cover = $project->cover()->toFile() ?? $project->image(); ?>
<article class="project-preview">
  <a class="project-photo" href="<?= $project->url() ?>" aria-label="Explore <?= esc($project->title()->value(), 'attr') ?>"><?php ja_image($cover, '(min-width: 900px) 52vw, 100vw'); ?><span class="photo-arrow" aria-hidden="true"><?= ja_icon('diagonal') ?></span></a>
  <div class="project-caption"><h3><a href="<?= $project->url() ?>"><?= $project->title()->esc() ?></a></h3><span><?= $project->category()->esc() ?></span></div>
  <p class="project-location"><?= $project->location()->esc() ?></p>
</article>
