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

# Hot reload: Octane's --watch turns octane.watch (config/octane.php) into `watch` directives,
# which the image's Caddyfile places inside the Octane `worker {}` block.
WATCH=""
case "$WEBSERVER" in
*-watch) WATCH="--watch" ;;
esac

# Run composer install if vendor directory does not exist
if [ ! -d "$APP_BASE_DIR/vendor" ]; then
    echo "Vendor directory not found. Running composer install..."
    composer install --no-interaction --optimize-autoloader
fi

if [ ! -d "$APP_BASE_DIR/node_modules" ]; then
    echo "Node modules directory not found. Running bun install..."
    bun install
fi

# Coloured output comes from FORCE_COLOR, set in the Dockerfile — see the comment there. Flushing
# needs nothing: PHP CLI runs with implicit_flush=On and output_buffering=0, so it writes to a pipe
# immediately.
#
# exec: makes concurrently PID 1 instead of leaving this shell there. A POSIX shell waiting on a
# child does not forward SIGTERM to it, while concurrently handles SIGHUP/SIGINT/SIGTERM and kills
# its children, so `docker stop` shuts the stack down cleanly.
exec bunx concurrently \
    -c "red.bold,magenta.bold,yellow.bold" \
  "php $PHP_INI_FLAGS $ARTISAN octane:start --host=$SERVER_NAME --port=$PORT $HTTPS --server=frankenphp --admin-port=$CADDY_ADMIN_PORT $WATCH $EXTRA_OCTANE_FLAGS --caddyfile=/etc/frankenphp/Caddyfile" \
  "php artisan pail --timeout=0" \
  "bun dev" \
  --names=server,logs,vite \
  --kill-others
