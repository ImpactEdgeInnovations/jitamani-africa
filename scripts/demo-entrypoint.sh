#!/bin/sh
set -eu

# Railway's runtime can reintroduce an MPM after the image build. Normalize
# again immediately before starting mod_php, which requires prefork.
a2dismod mpm_event mpm_worker
a2enmod mpm_prefork
apache2ctl -t
exec apache2-foreground
