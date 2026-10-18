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
})();
