# cPanel setup and controlled launch

This is a deployment guide, not evidence of a completed live deployment. The existing domain, DNS, business email and old application have not been changed.

## 1. Confirm the account

Verify supported PHP (8.4 preferred), Kirby-required extensions, GD/ImageMagick, rewrite support, HTTPS, writable content/media/cache/session paths, private storage outside the document root, resource limits and working backups. Confirm the actual web server; the included `.htaccess` targets Apache-compatible hosting. If the provider uses nginx without Apache rewrite handling, ask for equivalent protected-directory and front-controller rules.

Do not upgrade shared-account PHP without checking other applications. The original audit only observed a public PHP 8.2 header, not account-level capabilities.

## 2. Preserve the old site

Back up its files, database, media, routing rules and relevant configuration securely off-account. Confirm its actual source/admin and whether existing `/login` or other customer-facing functions have active dependencies before retirement. Preserve legitimate inquiries and other records even if the replacement has fewer public features. Test a restore in isolation.

Record existing DNS/mail dependencies. The audit observed Google MX and SPF containing `+a`; changing the website IP can therefore alter sender authorization. Staying on cPanel should not require a nameserver or email migration. Do not cancel or overwrite other account services.

## 3. Prepare an isolated staging copy

Run `composer install --no-dev --prefer-dist --optimize-autoloader` locally, then `php scripts/package.php`. Upload the generated archive through cPanel File Manager to an isolated staging document root and extract it, including `.htaccess`. This avoids requiring SSH/Composer on the host.

The package includes initial content. Never extract a full initial-content archive over a site that already has newer editor changes. Later releases should update templates/assets/dependencies without overwriting content, account files, private config or inquiry records.

Keep staging password-protected. With no canonical URL configured, this build sends a noindex header and disallows indexing in robots.txt; those are not substitutes for access protection.

Create a private inquiry directory outside `public_html`, owned by the application user with restrictive permissions. Copy `site/config/config.local.php.example` to `site/config/config.local.php`, enter the real path and authorised SMTP details, and leave `ja.canonical` null during staging. This untracked file is explicitly loaded by the app and CLI scripts. Never paste its secrets into a ticket, commit or report.

Use an approved test inbox while testing. Confirm submission validation, durable storage, inbox receipt, clear errors, retries and record permissions. SPF/DKIM/DMARC alignment depends on the actual authorised sender; do not guess DNS changes.

## 4. Set up the editor and licence

Create the owner's first Kirby account locally via `/panel`; the owner enters their own password. Securely transfer the account directory to staging if using that account. It is excluded from the source repository and deployment package. Alternatively, use a protected provider-assisted setup for the first production account. Do not leave Panel installation enabled on a publicly accessible server.

Add individual content-editor accounts, verify publishing and image uploads, and complete the short editing guide. Obtain the appropriate commercial Kirby licence before going live. Store the licence privately, not in Git.

## 5. Review and switch

Get approval for the actual release before live changes. Confirm final content/photos and privacy/retention policy. Keep `/`, `/about`, `/services`, `/contact`, `/blogs` and the two exact article slugs. New project stories live under `/work/`.

For production, set `ja.canonical` to `https://jitamaniafrica.com`, keep `debug` false and `panel.install` false, configure production SMTP and a private inquiry path. The application redirects other hosts/schemes to this base while preserving the request path/query. Test behind the actual server/proxy to avoid HTTPS redirect loops; the current check uses the web server's `HTTPS=on` signal rather than trusting arbitrary forwarded headers. Set the same environment settings for any maintenance CLI job.

Production mail mode must be SMTP. Loopback log mode is limited to the PHP development server; a request with a forged localhost Host header on cPanel does not enable it. A response accepted by SMTP is not a guarantee of inbox placement: verify a real agreed test in the intended inbox.

Protect both HTTPS host certificates and existing email services. Select the minimal document-root/release switch with a recorded rollback path; change DNS only if actually required and separately authorised. Keep the old release available during the overlap and preserve any new inquiries during rollback.

## 6. Finish acceptance and operation

Check important URLs, 404s, sitemap, canonical redirects, production noindex removal, forms, mail send/receive, mobile menu, phone links and staff editing. Confirm private paths return 403/404. Schedule off-account backups of content, account/config files and retained inquiries with access control, and demonstrate restoration.

Optional cPanel cron, with the account's correct PHP binary and absolute paths:

```text
*/10 * * * * /path/to/php /home/USER/site/scripts/inquiries.php retry
15 3 * * * /path/to/php /home/USER/site/scripts/inquiries.php purge 30
```

These are examples for the owner's approved operating policy, not installed jobs. Retry may deliver pending inquiries; purge permanently removes expired records. Agree retention first and review private CLI error output for failures. No always-on worker or lead dashboard is required.

Monitor initial errors and mail delivery, keep supported PHP/Kirby versions updated and periodically restore a backup in isolation. Do not interpret a successful ZIP upload as launch acceptance.
