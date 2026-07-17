#!/bin/sh
set -eu

# Install project package manager
corepack install

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

unbuffer pnpx concurrently \
    -c "#93c5fd,#fdba74" \
  "unbuffer php $PHP_INI_FLAGS $ARTISAN octane:start --host=$SERVER_NAME --port=$PORT $HTTPS --server=frankenphp --admin-port=$CADDY_ADMIN_PORT $WATCH $EXTRA_OCTANE_FLAGS" \
  "while ! nc -z localhost ${PORT}; do sleep 1; done && unbuffer pnpm dev" \
  --names=server,vite \
  --kill-others
