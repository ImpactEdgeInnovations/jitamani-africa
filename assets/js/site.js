(() => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('#primary-nav');
  if (toggle && nav) {
    toggle.hidden = false;
    nav.dataset.enhanced = '';
    const close = (restoreFocus = false) => {
      toggle.setAttribute('aria-expanded', 'false');
      nav.classList.remove('is-open');
      toggle.querySelector('[data-menu-label]').textContent = 'Menu';
      if (restoreFocus) toggle.focus();
    };
    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') !== 'true';
      toggle.setAttribute('aria-expanded', String(open));
      nav.classList.toggle('is-open', open);
      toggle.querySelector('[data-menu-label]').textContent = open ? 'Close' : 'Menu';
    });
    document.addEventListener('keydown', event => {
      if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') close(true);
    });
    document.addEventListener('click', event => {
      if (!nav.contains(event.target) && !toggle.contains(event.target)) close();
    });
    nav.addEventListener('click', event => { if (event.target.closest('a')) close(); });
    matchMedia('(min-width: 761px)').addEventListener('change', () => close());
  }
  document.querySelector('[data-form-errors]')?.focus();

  // Reveal once, without hiding content before JavaScript or the observer runs.
  // Text and anchor destinations remain available if enhancement is unavailable.
  const revealPreference = matchMedia('(prefers-reduced-motion: reduce)');
  if ('IntersectionObserver' in window && !revealPreference.matches) {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const target = entry.target;
        if (!revealPreference.matches) target.classList.add('is-revealed');
        observer.unobserve(target);
      });
    }, { threshold: 0, rootMargin: '0px 0px -32px 0px' });
    const targets = document.querySelectorAll('.home-introduction, .selected-work .section-heading, .project-preview, .home-digital > div, .home-services, .about-story, .service-detail, .platform-preview, .case-study-row');
    targets.forEach(target => {
      // Anything already visible (including a direct hash destination) stays still.
      if (target.getBoundingClientRect().top >= window.innerHeight) observer.observe(target);
    });
    revealPreference.addEventListener('change', () => {
      if (revealPreference.matches) observer.disconnect();
    });
  }

  const strip = document.querySelector('[data-brand-strip]');
  if (strip) {
    const motionPreference = matchMedia('(prefers-reduced-motion: reduce)');
    const button = strip.querySelector('.brand-motion-toggle');
    const duplicate = strip.querySelector('[aria-hidden="true"]');
    const viewport = strip.querySelector('.brand-viewport');
    const configure = () => {
      const animate = !motionPreference.matches;
      strip.classList.toggle('is-enhanced', animate);
      duplicate.hidden = !animate;
      button.hidden = !animate;
      viewport.setAttribute('aria-label', animate ? 'Brands and collaborators; animation pauses while focused' : 'Brands and collaborators; scroll horizontally to explore');
    };
    button.addEventListener('click', () => {
      const paused = strip.classList.toggle('is-paused');
      button.setAttribute('aria-pressed', String(paused));
      button.textContent = paused ? 'Resume logos' : 'Pause logos';
    });
    motionPreference.addEventListener('change', configure);
    configure();
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(entries => {
        const visible = entries[0].isIntersecting;
        strip.classList.toggle('is-offscreen', !visible);
        // Compositor transforms do not consistently trigger native lazy loading.
        // Load the small, self-hosted collection once the row comes into view.
        if (visible) strip.querySelectorAll('img[loading="lazy"]').forEach(image => { image.loading = 'eager'; });
      }).observe(strip);
    }
  }

  const mark = document.querySelector('[data-brand-reveal]');
  const video = mark?.querySelector('video');
  if (video && 'IntersectionObserver' in window) {
    const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)');
    let started = false;
    let finished = false;
    const finish = () => {
      finished = true;
      video.pause();
      mark.classList.remove('is-playing');
    };
    video.addEventListener('playing', () => {
      if (finished || reducedMotion.matches) finish();
      else mark.classList.add('is-playing');
    });
    // The supplied clip has a complete monogram before its closing frames.
    // Hold a matching still rather than looping or showing the closing transition.
    video.addEventListener('timeupdate', () => { if (video.currentTime >= 3.7) finish(); });
    video.addEventListener('ended', finish);
    video.addEventListener('error', finish);
    reducedMotion.addEventListener('change', () => { if (reducedMotion.matches) finish(); });
    document.addEventListener('visibilitychange', () => { if (document.hidden && started) finish(); });
    const observer = new IntersectionObserver(entries => {
      for (const entry of entries) {
        if (entry.isIntersecting && entry.intersectionRatio >= 0.35 && !started && !finished && !reducedMotion.matches) {
          started = true;
          video.muted = true;
          video.src = video.dataset.src;
          video.play().catch(finish);
        } else if (!entry.isIntersecting && started) {
          finish();
        }
        if (finished) observer.disconnect();
      }
    }, { threshold: [0, 0.35] });
    observer.observe(mark);
  }
})();
