<?php
$description = $page->description()->or($site->description())->value();
$title = $page->metatitle()->isNotEmpty() ? $page->metatitle()->value() : $page->title()->value() . ' — ' . $site->title()->value();
$og = $site->file('dining.png');
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f7f3ea">
  <title><?= esc($title) ?></title>
  <meta name="description" content="<?= esc($description, 'attr') ?>">
  <link rel="canonical" href="<?= esc(ja_canonical($page), 'attr') ?>">
  <meta property="og:site_name" content="Jitamani Africa">
  <meta property="og:title" content="<?= esc($title, 'attr') ?>">
  <meta property="og:description" content="<?= esc($description, 'attr') ?>">
  <meta property="og:type" content="<?= $page->intendedTemplate()->name() === 'article' ? 'article' : 'website' ?>">
  <meta property="og:url" content="<?= esc(ja_canonical($page), 'attr') ?>">
  <?php if ($og): ?><meta property="og:image" content="<?= esc($og->resize(1200)->url(), 'attr') ?>"><?php endif ?>
  <link rel="icon" href="<?= url('assets/icons/favicon.svg') ?>" type="image/svg+xml">
  <link rel="preload" href="<?= url('assets/fonts/inter-600.ttf') ?>" as="font" type="font/ttf" crossorigin>
  <link rel="stylesheet" href="<?= url('assets/css/site.css') ?>?v=6">
  <script src="<?= url('assets/js/site.js') ?>?v=1" defer></script>
</head>
<body class="page-<?= esc($page->intendedTemplate()->name(), 'attr') ?>">
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header wrap">
  <a class="wordmark" href="<?= $site->url() ?>" aria-label="Jitamani Africa home"><span>Jitamani</span><span>Africa</span></a>
  <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" hidden><span data-menu-label>Menu</span><span class="menu-lines" aria-hidden="true"></span></button>
  <nav class="primary-nav" id="primary-nav" aria-label="Main navigation">
    <?php foreach (['home' => 'Home', 'about' => 'About', 'services' => 'Services', 'work' => 'Our Work', 'contact' => 'Contact'] as $id => $label): $item = page($id); ?>
    <a href="<?= $item->url() ?>"<?= ($page->is($item) || $page->isDescendantOf($item)) ? ' aria-current="page"' : '' ?>><?= $label ?></a>
    <?php endforeach ?>
  </nav>
</header>
<main id="main" tabindex="-1">
