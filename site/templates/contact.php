<?php snippet('header') ?>
<section class="contact-layout wrap" id="inquiry">
  <div class="contact-copy"><p class="eyebrow">Contact</p><h1><?= $page->headline()->esc() ?><br><span class="accent"><?= $page->headlineaccent()->esc() ?></span></h1><p class="lead"><?= $page->intro()->esc() ?></p><div class="contact-channels"><a class="contact-email" href="mailto:<?= $site->email()->esc() ?>"><?= $site->email()->esc() ?></a><a class="text-link" href="<?= ja_whatsapp() ?>" target="_blank" rel="noopener noreferrer">Chat on WhatsApp <?= ja_icon('whatsapp') ?></a><a class="phone-link" href="tel:<?= esc(preg_replace('/[^+\d]/', '', $site->phone()->value()), 'attr') ?>"><?= $site->phone()->esc() ?></a></div><p class="contact-note">Based in Kenya.<br>Open to possibilities.</p></div>
  <div class="contact-form-column">
    <?php if ($values['interest'] !== '' && option('ja.demo')): ?><p class="form-intro">Your interest: <?= esc(JitamaniInquiries::interests()[$values['interest']]) ?></p><?php endif ?>
    <?php if ($success): ?>
    <div class="form-success" role="status"><span class="eyebrow"><?= $success['local'] ? 'Local preview' : 'Message received' ?></span><h2><?= $success['local'] ? 'Your test is saved.' : 'Thank you for saying hello.' ?></h2><p><?= $success['local'] ? 'The inquiry was saved locally. No email was sent from this preview.' : 'Your inquiry has been saved and passed to our email service. We look forward to continuing the conversation.' ?></p><a class="text-link" href="<?= $page->url() ?>">Send another message <?= ja_icon() ?></a></div>
    <?php elseif (option('ja.demo')): ?>
    <div class="form-success"><span class="eyebrow">Website preview</span><h2>A look at what’s coming.</h2><p>This is a demonstration website. The inquiry form is disabled here; messages are not collected or sent.</p><a class="text-link" href="mailto:<?= $site->email()->esc() ?>">Contact us by email <?= ja_icon('diagonal') ?></a></div>
    <?php else: ?>
    <p class="form-intro"><?= $page->formintro()->esc() ?></p>
    <?php if ($errors): ?><div class="form-errors" role="alert" tabindex="-1" data-form-errors><h2>Please check your message.</h2><ul><?php foreach ($errors as $key => $error): ?><li><?php if ($key !== 'form'): ?><a href="#<?= esc($key) ?>"><?= esc($error) ?></a><?php else: ?><?= esc($error) ?><?php endif ?></li><?php endforeach ?></ul></div><?php endif ?>
    <form method="post" action="<?= $page->url() ?>#inquiry" class="inquiry-form">
      <input type="hidden" name="csrf" value="<?= csrf() ?>">
      <div class="honeypot" aria-hidden="true"><label for="website">Leave this field empty</label><input type="text" name="website" id="website" tabindex="-1" autocomplete="off"></div>
      <?php foreach (['name' => ['Your name', 'text', 'name', 120], 'email' => ['Email address', 'email', 'email', 254], 'phone' => ['Phone (optional)', 'tel', 'tel', 40]] as $key => [$label, $type, $autocomplete, $limit]): ?>
      <div class="form-field"><label for="<?= $key ?>"><?= $label ?></label><input id="<?= $key ?>" name="<?= $key ?>" type="<?= $type ?>" autocomplete="<?= $autocomplete ?>" maxlength="<?= $limit ?>" value="<?= esc($values[$key], 'attr') ?>"<?= $key !== 'phone' ? ' required' : '' ?><?= isset($errors[$key]) ? ' aria-invalid="true" aria-describedby="' . $key . '-error"' : '' ?>><?php if (isset($errors[$key])): ?><p class="field-error" id="<?= $key ?>-error"><?= esc($errors[$key]) ?></p><?php endif ?></div>
      <?php endforeach ?>
      <div class="form-field"><label for="interest">What would you like help with? (optional)</label><select name="interest" id="interest"<?= isset($errors['interest']) ? ' aria-invalid="true" aria-describedby="interest-error"' : '' ?>><option value="">Choose a service</option><?php foreach (JitamaniInquiries::interests() as $key => $label): ?><option value="<?= esc($key, 'attr') ?>"<?= $values['interest'] === $key ? ' selected' : '' ?>><?= esc($label) ?></option><?php endforeach ?></select><?php if (isset($errors['interest'])): ?><p class="field-error" id="interest-error"><?= esc($errors['interest']) ?></p><?php endif ?></div>
      <div class="form-field"><label for="message">Your message</label><textarea name="message" id="message" rows="4" minlength="10" maxlength="5000" required<?= isset($errors['message']) ? ' aria-invalid="true" aria-describedby="message-error"' : '' ?>><?= esc($values['message']) ?></textarea><?php if (isset($errors['message'])): ?><p class="field-error" id="message-error"><?= esc($errors['message']) ?></p><?php endif ?></div>
      <div class="form-submit"><button class="button" type="submit">Send inquiry <?= ja_icon('diagonal') ?></button><a href="<?= page('privacy')->url() ?>">Privacy</a></div>
      <p class="form-smallprint">We use these details to respond to your inquiry.</p>
      <?php if (option('ja.local')): ?><p class="local-preview-note">Local preview: submissions are saved on this computer; email delivery is disabled.</p><?php endif ?>
    </form>
    <?php endif ?>
  </div>
</section>
<?php snippet('footer') ?>
