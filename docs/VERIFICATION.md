# Local verification — 18 October 2026

## Completed

- **55 PHP/content checks:** main pages, four service records, two original project stories, retained article content/dates, inquiry validation, rate limiting, durable private recovery storage, local delivery mode, safe failure when SMTP is unconfigured, valid editing blueprints, five-page editor navigation, all three shared photographs and restricted editor access to system/user management.
- **72 local HTTP checks:** eleven public page/article routes, one main heading per template, preview noindex, meaningful image descriptions, generated WebP responses, private-directory protections, designed 404, sitemap/robots, CSRF rejection, server validation, escaped input redisplay, post/redirect/get, saved inquiry record, non-repeated success and Panel setup page.
- **28 responsive states:** Home, About, Services, Our Work, cocktail project, Contact and blog archive at 320, 390, 768 and 1440 CSS pixels. No measured horizontal document overflow.
- Mobile menu opens. Escape closes it and returns focus to the menu button.
- A browser-driven synthetic inquiry was saved locally and displayed the explicit no-email local confirmation.
- Desktop screenshots reviewed for Home, About, Services, Our Work and Contact, plus phone/menu/form screenshots.
- **24 PHP source files** passed PHP syntax checks before packaging.
- Composer security audit reported no published vulnerability advisories for installed dependencies at the check time.
- A cPanel ZIP was generated and inspected: runtime dependencies, initial content and `.htaccess` included; private config, accounts, sessions, caches, Git metadata and inquiry records excluded. Dependencies are locked in `composer.lock`.

The retained local evidence is under ignored `artifacts/`. Regenerate the archive after changing packaged source files with `php scripts/package.php`.

## Limits and launch dependencies

The website is a local build and has not been deployed to Jitamani's live hosting. No production DNS, hosting, mail or database change was made.

Production SMTP credentials have not been configured; real business-inbox receipt and sender alignment remain to be tested with an agreed test message. All form submissions in these checks used synthetic local data and log mode. The SMTP-unconfigured failure test did not connect to an external mail service.

The Kirby Panel setup page and editor definitions are verified. The owner still needs to create their first account and complete a practical edit/upload/publish review. No shared administrator password or licence is supplied.

cPanel PHP/extensions, rewrite handling, permissions, backup restoration, private inquiry location, HTTPS canonical redirects and any old application/login dependencies need verification on the actual account. The local PHP router checks are not proof that an uninspected Apache/nginx host is configured correctly.

The layout/keyboard checks are not full WCAG certification. No physical-device/browser matrix, complete screen-reader audit, field Core Web Vitals or conversion-uplift measurement was performed. Review copy, image permissions and the final privacy/retention policy before launch.
