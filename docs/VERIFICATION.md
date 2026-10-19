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


## Fresh design implementation — 18 October 2026

Replaced the original stylesheet with the approved aubergine/ivory visual direction: split photography hero, stacked sans wordmark, Inter headings with Newsreader accents, aligned project images, ruled services and a compact contact band. Applied the shared identity to all templates, preserving article URLs and the inquiry backend. Uses original archive photography.

Validation: 55 application checks and 73 localhost HTTP checks passed. Five main pages checked at 1440, 768, 390 and 320px: no horizontal overflow or broken loaded images. Mobile navigation opens and closes with Escape. Desktop homepage/contact and mobile homepage visually reviewed. Production SMTP and cPanel deployment remain separate launch steps.


## UI and content refinements

Added company introduction, project summaries and optional case-study sections based on the existing archive. Improved hero crop and internal heading scale. Added mobile WhatsApp shortcut with safe-area spacing, hidden during form entry and menu use. Editor fields now include image guidance and optional verified outcomes.

Validation: 55 application checks passed. Homepage, work index, both project stories and contact page checked at 1440/390/320px without horizontal overflow. Browser checks confirmed WhatsApp hides during input focus and menu use. No private SMTP configuration or complete SMTP environment is available; live delivery remains unverified. Original high-resolution photos and original brand artwork have not been supplied.


## Final messaging and spacing pass — 19 October 2026

Updated the hero to “Build your business. Create memorable experiences.”, clarified the supporting copy, tightened section spacing and labelled the service list. Moved the documented project role above the cover image, omitting that section when not supplied.

Verified the homepage and both project pages at 1440, 768, 390 and 320px: no horizontal overflow. Reviewed mobile homepage and desktop project layout visually. PHP syntax and diff whitespace checks passed. Live inbox delivery, owner account setup, physical-phone checks and higher-resolution image replacement remain pending access or original files.


## AI positioning and portfolio — 19 October 2026

Added three owner-confirmed AI platform projects: DukaPilot, Her Africa Table and CaseReady. Platform work and event experiences are separate sections, and the two original events/article paths remain. No training or event history was invented for the platforms. Platform artwork is typographic, with public website links. Added homepage AI consulting/training and service offerings, updated About/metadata, and an optional allowlisted inquiry interest.

Validation: 62 application checks and 84 local HTTP checks passed, including platform/event separation, preserved archive content, three new detail routes, training preselection and saved inquiry interest. Seven affected page/route variants checked at 1440/768/390/320px (28 states): no horizontal overflow. Work index visually reviewed on desktop and mobile. No external mail sent during tests.
