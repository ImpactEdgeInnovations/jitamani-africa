# Railway client-review demo

This deploys a disposable design preview independently of the client's hosting.
The Docker image runs PHP 8.4 and Apache, installs locked Composer dependencies,
and enables the existing rewrite/private-directory rules.

## Dashboard steps

1. Sign into https://railway.com with your GitHub account.
2. Select **New Project → Deploy from GitHub repo**. Grant Railway access to
   `ImpactEdgeInnovations/jitamani-africa` if needed.
3. Open the service's **Settings → Source** and select branch
   **codex/editorial-website**. Keep the root directory at the repository root.
4. Keep the automatically detected **Dockerfile** builder. Leave custom build
   and start commands empty. If a build started from another branch, redeploy
   after selecting the correct branch.
5. In **Variables**, add **PORT=80**, then apply/deploy any pending changes.
   `JA_DEMO=1` is already the default in the image. Do not add a canonical URL
   or production mail credentials for this review deployment.
6. Wait for the deployment to become active. Under **Settings → Networking →
   Public Networking**, choose **Generate Domain** and use **target port 80**.
7. Open the generated HTTPS address and review Home, About, Services, Our Work,
   both project stories, Contact and the archive. Share this address with the client.

No database, custom domain, persistent volume or local Docker installation is
needed for this design preview. Railway handles the container build. Updates
to the connected branch can trigger a new deployment.

## Preview behaviour

- The existing noindex header and disallow-all robots rules apply while no
  canonical URL is set. The generated URL is public, not password-protected.
- `JA_DEMO=1` disables inquiry collection/sending and first-account installation,
  and turns debug output off. Contact shows a clear preview notice; real email
  and WhatsApp links remain available.
- Files changed inside the container are disposable. Do not create editor
  accounts, collect real inquiries or use this service for production editing.
  An editable staging site requires persistent storage and separate setup.
- Secrets, local accounts, local inquiry records and licence files are excluded
  from the Docker build context.
- The cPanel upload package uses the normal configuration, without demo mode,
  unless you explicitly set `JA_DEMO=1` on that host.

## Billing and shutdown

Railway offers a trial subject to eligibility/credits and has usage-based paid
plans. Review current pricing and set a spending limit in your workspace.
After review, remove the demo service/project when it is no longer needed.

## Validation status

Application PHP syntax and demo-mode behaviour are checked locally. Docker is
not installed on the preparation machine, so the container image and Railway
deployment must be validated by the first Railway build and its logs. No live
demo has been provisioned as part of preparing these files.
