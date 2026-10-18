<?php snippet('header') ?>
<section class="page-intro wrap"><p class="eyebrow">Our work</p><h1><?= $page->headline()->esc() ?><br><span class="accent"><?= $page->headlineaccent()->esc() ?></span></h1><p class="lead"><?= $page->intro()->esc() ?></p></section>
<section class="work-collection wrap" aria-label="Selected project stories"><div class="project-grid"><?php foreach ($page->children()->listed() as $project) snippet('project-preview', compact('project')) ?></div></section>
<?php snippet('invitation') ?>
<?php snippet('footer') ?>
