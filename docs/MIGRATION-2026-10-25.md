# cPanel migration — 25 October 2026

## Live deployment

The rebuilt website is deployed at https://jitamaniafrica.com/ in `/home2/jitamani/public_html`. The owner authorised this migration. DNS, mailboxes, the legacy database and the separate services subdomain were not changed.

The release was built from commit `173a5ed`, with the additional `/contacts` to `/contact` redirect now recorded in source. Package: `jitamani-cpanel-20261025-055411.zip`, 1,108 files, SHA-256 `0bb7a672f90999656ed41454dd17412ed0d3aed90c0f0ae401ef65d14a65e3a8`. Production dependencies were packaged locally; Composer/SSH was not needed on the host.

Only the primary domain was set to PHP 8.4 in MultiPHP Manager. The services subdomain remains on its existing inherited PHP version. The production `.htaccess` includes the host's PHP handler in addition to application routing rules.

## Retained data and rollback

- Original document root: `/home2/jitamani/jitamani-legacy-20261025` (outside the public document root).
- Server archive: `/home2/jitamani/jitamani-legacy-backup-20261025.zip`.
- Owner-approved private local backup: `/Users/macbook/Desktop/Jitamani-Migration-2026-10-25`.
- Local website archive: `legacy-website.zip`, 450,398,186 bytes, 46,836 entries; ZIP integrity check passed.
- Local database export: `legacy-database.sql.gz`; gzip and SQL structure checked. A database restoration rehearsal was not performed.

Both original blog URLs and the blog archive remain. The original public `/images` directory was copied into the replacement: 86 files, 31,504,440 bytes. The old `/contacts` path redirects to `/contact`.

For rollback, first retain any new content, accounts, generated media and private inquiries. Rename the new `public_html` to a dated rollback folder, then rename `jitamani-legacy-20261025` back to `public_html`. Review the primary-domain PHP setting against the old Laravel application's requirements and restore its previous inherited PHP 8.1 setting if appropriate. Do not change the services subdomain. The old database was left intact. These are rollback instructions, not an executed rollback.

## Private production settings

`site/config/config.local.php` on the server sets the canonical URL, disables debug and public Panel installation, enables SMTP, and stores inquiries outside the document root at `/home2/jitamani/jitamani-private/inquiries`. The inquiry directory is created with restrictive permissions on first use.

SMTP reuses the authorised legacy identity by reading `/home2/jitamani/jitamani-legacy-20261025/.env` with `parse_ini_file(..., INI_SCANNER_RAW)`. Passwords were not committed to source or embedded in this report. **Do not delete, rename or relocate that private legacy folder until SMTP configuration has been securely separated and verified.**

The recipient is `seina@jitamaniafrica.com`. The owner declined a migration-test email, so no contact submission was made and SMTP delivery/inbox placement remains unverified. Existing mailbox send/receive was not exercised. No retry or purge cron jobs were installed.

## Verification and acceptance

- Local application suite: 63 checks passed before packaging.
- Production main pages, archive, both original blog slugs, three digital platform pages, sitemap and robots returned successful responses.
- Production canonical URLs and indexing settings were checked; the staging noindex restriction is removed.
- `/contacts` resolved to `/contact`; HTTPS and `www` canonical redirects were verified in Chrome.
- Private configuration/content paths returned 403/404, and an unknown URL returned 404.
- Live homepage and contact page were visually checked at a mobile viewport; opening the menu and navigating to Contact worked. Form fields and CSRF token were inspected without submitting.
- A transient period of connection resets occurred after initial successful checks. The site subsequently loaded again in Chrome. The available cPGuard WAF log showed no new incident for the migration date; the cause was not established and no firewall protection was disabled.

Screenshots and HTTP verification records are retained in the private local migration folder. These checks do not replace a delivery test or a restoration rehearsal.

Remaining owner setup: create the owner's Kirby account through a protected setup with the owner entering their own password, verify content/image editing, and confirm the required commercial Kirby licence. Public Panel installation remains disabled until that protected setup is arranged. Agree an ongoing backup and retention policy before enabling maintenance jobs.

## Future releases

Do not extract an initial-content release over newer editor content. Preserve production private config, accounts, inquiry records and legacy `/images`. Use a reviewed release switch and retain the prior version until acceptance. The Railway demo remains separate from cPanel production; pushing Git changes does not automatically update this cPanel document root.
