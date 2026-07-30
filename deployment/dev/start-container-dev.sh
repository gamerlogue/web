#!/bin/sh
set -eu

# Common settings
SERVER_NAME="${SERVER_NAME:-0.0.0.0}"
# Extract port from CADDY_ADMIN if it is set, otherwise use default 2019
if [ -n "${CADDY_ADMIN:-}" ]; then
    CADDY_ADMIN_PORT=$(echo "$CADDY_ADMIN" | awk -F: '{print $2}')
else
    CADDY_ADMIN_PORT=2019
fi

WEBSERVER="${WEBSERVER:-frankenphp}"

ARTISAN="$APP_BASE_DIR/artisan"
PHP_INI_FLAGS="-d variables_order=EGPCS"
EXTRA_OCTANE_FLAGS="${EXTRA_OCTANE_FLAGS:-}"

# HTTPS settings
if [ "${SSL_MODE:-off}" = "off" ]; then
    HTTPS=""
    PORT="${CADDY_HTTP_PORT:-80}"
else
    HTTPS="--https"
    PORT="${CADDY_HTTPS_PORT:-443}"
fi

# Enable watch if WEBSERVER ends with "-watch".
#
# config/octane.php owns the path list, so we read it from there instead of duplicating it. Two
# transformations are mandatory before handing it to FrankenPHP (see deployment/AUDIT.md §3.1-bis):
#  - single file paths must be dropped: a `watch <file>` segfaults FrankenPHP (SIGSEGV, exit 139)
#    when the watcher restarts the workers while they are still booting;
#  - directories must be narrowed to .php, otherwise the resources/ts rewrites done by
#    Vite/wayfinder and the bootstrap/cache ones done by Laravel trigger a reload storm.
#
# Note: Octane's --watch cannot be used, because /etc/frankenphp/Caddyfile interpolates
# {$CADDY_SERVER_WATCH_DIRECTIVES} under `frankenphp {}`, where `watch` is not a valid
# subdirective. It has to live inside `worker {}`, so we inject it through FRANKENPHP_CONFIG.
WATCH_DIRECTIVES=""
case "$WEBSERVER" in
*-watch)
    WATCH_PATHS=$(php "$ARTISAN" config:show octane.watch --no-ansi | awk '/^ *[0-9]+ /{print $NF}')
    [ -n "$WATCH_PATHS" ] || { echo "Unable to read octane.watch from config." >&2; exit 1; }
    # set -f: without noglob the shell would expand the patterns (database/**/*.php would become
    # the list of matching files, which the -d test then drops, silently losing the pattern).
    set -f
    for p in $WATCH_PATHS; do
        case "$p" in
        *'*'*) ;;                                        # already a pattern: use it as is
        *)  [ -d "$APP_BASE_DIR/$p" ] || continue        # single file: skip, it would crash
            p="$p/**/*.php" ;;
        esac
        WATCH_DIRECTIVES="$WATCH_DIRECTIVES
    watch $APP_BASE_DIR/$p"
    done
    set +f
    ;;
esac

export FRANKENPHP_CONFIG="worker {
  file \"$APP_BASE_DIR/public/frankenphp-worker.php\"$WATCH_DIRECTIVES
}"

# Run composer install if vendor directory does not exist
if [ ! -d "$APP_BASE_DIR/vendor" ]; then
    echo "Vendor directory not found. Running composer install..."
    composer install --no-interaction --optimize-autoloader
fi

if [ ! -d "$APP_BASE_DIR/node_modules" ]; then
    echo "Node modules directory not found. Running bun install..."
    bun install
fi

unbuffer bunx concurrently \
    -c "red.bold,magenta.bold,yellow.bold" \
  "unbuffer php $PHP_INI_FLAGS $ARTISAN octane:start --host=$SERVER_NAME --port=$PORT $HTTPS --server=frankenphp --admin-port=$CADDY_ADMIN_PORT $EXTRA_OCTANE_FLAGS --caddyfile=/etc/frankenphp/Caddyfile" \
  "php artisan pail --timeout=0" \
  "unbuffer bun dev" \
  --names=server,logs,vite \
  --kill-others
