<?php $animated = $animated ?? false; ?>
<section class="invitation<?= $animated ? ' invitation--animated' : '' ?>" aria-labelledby="invitation-title">
  <div class="invitation-inner wrap">
    <div class="invitation-copy">
      <h2 id="invitation-title"><?= $site->contactheading()->esc() ?></h2>
      <?php if ($animated): ?><p>Strategic insight. Memorable experiences. New possibilities for your business.</p><?php endif ?>
      <div class="invitation-bottom"><a class="text-link" href="<?= page('contact')->url() ?>">Let’s talk <?= ja_icon('diagonal') ?></a><a class="whatsapp-link" href="<?= ja_whatsapp() ?>" target="_blank" rel="noopener noreferrer">WhatsApp <?= ja_icon('diagonal') ?></a></div>
    </div>
    <?php if ($animated): ?>
    <div class="invitation-mark" data-brand-reveal aria-hidden="true">
      <svg class="brand-color-filter" xmlns="http://www.w3.org/2000/svg"><defs><filter id="ja-mark-colors" color-interpolation-filters="sRGB"><feComponentTransfer><feFuncR type="table" tableValues=".196078 .968627"/><feFuncG type="table" tableValues=".121569 .952941"/><feFuncB type="table" tableValues=".168627 .917647"/></feComponentTransfer></filter></defs></svg>
      <div class="invitation-mark-visual">
        <img src="<?= url('assets/motion/ja-still.png') ?>" alt="" width="800" height="800" loading="lazy" decoding="async">
        <video data-src="<?= url('assets/motion/ja-reveal.webm') ?>" width="800" height="800" muted playsinline preload="none" tabindex="-1" disablepictureinpicture disableremoteplayback></video>
      </div>
    </div>
    <?php endif ?>
  </div>
</section>
