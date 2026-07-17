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
if [ "$SSL_MODE" = "off" ]; then
    HTTPS=""
    PORT="${CADDY_HTTP_PORT:-80}"
else
    HTTPS="--https"
    PORT="${CADDY_HTTPS_PORT:-443}"
fi

# Enable watch if WEBSERVER ends with "-watch"
if [ "${WEBSERVER}" = "${WEBSERVER%-watch}" ]; then
  WATCH="--watch"
else
  WATCH=""
fi

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
    -c "red.bold,yellow.bold" \
  "unbuffer php $PHP_INI_FLAGS $ARTISAN octane:start --host=$SERVER_NAME --port=$PORT $HTTPS --server=frankenphp --admin-port=$CADDY_ADMIN_PORT $WATCH $EXTRA_OCTANE_FLAGS" \
  "while ! nc -z localhost ${PORT}; do sleep 1; done && unbuffer bun dev" \
  --names=server,vite \
  --kill-others

tail -f /tmp/xdebug.log
