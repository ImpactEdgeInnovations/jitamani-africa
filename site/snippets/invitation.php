<section class="invitation wrap" aria-labelledby="invitation-title">
  <span class="eyebrow">A good place to begin</span>
  <h2 id="invitation-title"><?= $site->contactheading()->esc() ?></h2>
  <div class="invitation-bottom"><a class="text-link" href="<?= page('contact')->url() ?>">Let’s talk <?= ja_icon() ?></a><p><?= $site->contactintro()->esc() ?></p><a class="whatsapp-link" href="<?= ja_whatsapp() ?>" target="_blank" rel="noopener noreferrer">WhatsApp <?= ja_icon('whatsapp') ?></a></div>
</section>
