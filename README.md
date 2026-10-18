# Jitamani Africa

A small, bespoke Kirby website based on the approved editorial design: warm ivory, ink, deep teal and wine accents; self-hosted Newsreader and Inter; real photographs from the existing website. No frontend framework, Node server, database service, CRM or custom admin is needed.

## Run locally

Requirements: PHP 8.2–8.5 (8.4 recommended), Composer, standard Kirby PHP extensions and GD or ImageMagick for photographs.

```sh
composer install
composer start
```

Open **http://localhost:8000/**. To use the review port:

```sh
php -S 127.0.0.1:8088 router.php
```

The custom router protects private project directories while allowing Kirby to generate responsive images. Do not serve this PHP site with a static file server.

## Pages and editing

- Home, About, Services, Our Work and Contact are the five main pages.
- `/work/{slug}` contains project stories.
- `/blogs` and both original article URLs are preserved.
- `/privacy`, `/sitemap.xml`, `/robots.txt` and a designed 404 are included.
- Open `/panel` locally to create the owner's first account. No default/shared credentials are shipped. The owner sets their password themselves.
- Add everyday staff as **Content editor**. They can update text, images, projects and contact details; system settings and user management are restricted.
- Page layouts are fixed. Photographs include editable alternative text and source information.

See [the short editing guide](docs/EDITING.md).

## Contact form

Local PHP-server sessions from loopback addresses use **log mode**. Synthetic inquiries are saved under ignored `storage/inquiries/` and no email is sent. The confirmation explicitly says this. CSRF protection, server validation, honeypot, rate limiting, escaped redisplay and post/redirect/get are included.

Production uses authenticated SMTP and a protected recovery copy. A failed delivery keeps a pending record and gives an honest error with contact alternatives. No CRM or lead dashboard is included. Set real mail credentials only through an untracked private config or environment variables; never commit them.

Copy `site/config/config.local.php.example` to `site/config/config.local.php` and adapt it for the actual environment. The private file is ignored by Git and excluded from packaging. On cPanel, place inquiry storage **outside `public_html`** and configure the actual sender, recipient and authorised SMTP transport. Do not copy example SMTP values unchanged.

Environment alternatives: `JA_CANONICAL_URL`, `JA_MAIL_FROM`, `JA_MAIL_TO`, `JA_SMTP_HOST`, `JA_SMTP_PORT`, `JA_SMTP_SECURITY`, `JA_SMTP_USERNAME`, `JA_SMTP_PASSWORD`. The private config is also read by CLI maintenance commands.

Optional maintenance after production SMTP setup:

```sh
php scripts/inquiries.php retry
php scripts/inquiries.php purge 30
```

The first sends pending inquiries; the second permanently removes recovery copies older than the selected retention. Run them only under the site's agreed operating policy. They print references/counts, not messages. A cPanel cron may invoke them; no always-on worker is needed.

## Verification

```sh
composer test
python3 tests/http_smoke.py http://127.0.0.1:8088
composer audit
```

The HTTP suite refuses non-local hosts and checks local log mode before its synthetic submission. It verifies page/media responses, original article paths, CSRF/validation, safe redisplay, private-path protection, sitemap, 404 and retained inquiry/confirmation behaviour.

Browser review covers the main templates at 320, 390, 768 and 1440px, mobile menu/Escape/focus, and desktop/phone screenshots. This is not a full WCAG certification or field Core Web Vitals measurement. See [verification notes](docs/VERIFICATION.md).

## cPanel handover

Read [CPANEL.md](docs/CPANEL.md) before any live deployment. Keep domain and email arrangements intact. This repository has not been deployed to the live domain. SMTP/inbox delivery, hosting compatibility, owner account setup and the commercial Kirby licence must be completed before launch.

To make a local upload archive with dependencies already installed:

```sh
php scripts/package.php
```

It writes an ignored `dist/` archive containing runtime dependencies and initial content, excluding secrets, accounts, inquiry records, sessions and caches. Installing dependencies on the Mac before packaging avoids requiring Composer/SSH on cPanel.

## Content and licences

Source text and photographs come from the current public Jitamani site. Both articles retain their content, original dates and slugs; broken template links, duplicate sidebar content and draft citation debris were removed. New project summaries do not introduce numerical results, clients, awards or testimonials. Owner review of copy, image permissions and privacy/retention wording is required before launch.

Asset provenance is in [ASSETS.md](docs/ASSETS.md). Inter and Newsreader are self-hosted with their SIL Open Font License files. Kirby is commercial software; a valid site licence is required for production. Runtime dependencies retain their own licences. No commercial licence or account secret is included in Git.
