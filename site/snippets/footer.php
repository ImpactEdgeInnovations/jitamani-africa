</main>
<footer class="site-footer wrap">
  <div class="footer-top">
    <a class="wordmark" href="<?= $site->url() ?>"><span>Jitamani</span><span>Africa</span></a>
    <p>Thoughtful ideas.<br>Meaningful experiences.</p>
    <div class="footer-links"><a href="<?= page('contact')->url() ?>">Start a conversation <?= ja_icon('diagonal') ?></a><a href="<?= ja_whatsapp() ?>" rel="noopener noreferrer" target="_blank">WhatsApp <?= ja_icon('whatsapp') ?></a></div>
  </div>
  <div class="footer-bottom">
    <span>© <?= date('Y') ?> <?= $site->copyright()->esc() ?></span>
    <a href="<?= page('blogs')->url() ?>">From the archive</a>
    <a href="<?= page('privacy')->url() ?>">Privacy</a>
    <?php if ($site->linkedin()->isNotEmpty()): ?><a href="<?= esc($site->linkedin()->value(), 'attr') ?>" target="_blank" rel="noopener noreferrer">LinkedIn <?= ja_icon('diagonal') ?></a><?php endif ?>
    <span class="footer-location">Based in Kenya. Open to possibilities.</span>
  </div>
</footer>
<a class="mobile-whatsapp" href="<?= ja_whatsapp() ?>" target="_blank" rel="noopener noreferrer" aria-label="Chat with Jitamani Africa on WhatsApp (opens in a new tab)"><?= ja_icon('whatsapp') ?> <span>Let’s talk on WhatsApp</span> <?= ja_icon('diagonal') ?></a>
</body>
</html>
