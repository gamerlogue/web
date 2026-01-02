#!/bin/sh
set -eu

# Validate SUPERVISOR_PHP_USER
case "${SUPERVISOR_PHP_USER:-}" in
root|sail) ;;
*)
  echo "You should set SUPERVISOR_PHP_USER to either 'sail' or 'root'."
  exit 1
  ;;
esac

# Ensure scheduler programs run as the same user as PHP in dev
export USER="$SUPERVISOR_PHP_USER"

# Install project package manager
corepack install

# Common settings
SERVER_NAME="${SERVER_NAME:-0.0.0.0}"
PORT="${PORT:-443}"
ADMIN_PORT="${ADMIN_PORT:-2019}"
WEBSERVER="${WEBSERVER:-cli}"

PHP_BIN=$(which php)
ARTISAN="$ROOT/artisan"
PHP_INI_FLAGS="-d variables_order=EGPCS"

case "$WEBSERVER" in
cli)
  export SUPERVISOR_PHP_COMMAND="${PHP_BIN} ${PHP_INI_FLAGS} $ARTISAN serve --host=\"${SERVER_NAME}\" --port=${PORT} --https"
  ;;
octane|octane-watch)
  WATCH_FLAG=""
  if [ "$WEBSERVER" = "octane-watch" ]; then
    WATCH_FLAG="--watch"
  fi
  export SUPERVISOR_PHP_COMMAND="${PHP_BIN} ${PHP_INI_FLAGS} ${ARTISAN} octane:start ${WATCH_FLAG} --host=\"${SERVER_NAME}\" --port=${PORT} --admin-port=${ADMIN_PORT} --https --caddyfile=$ROOT/deployment/dev/Caddyfile"
  ;;
*)
  echo "Unknown WEBSERVER='${WEBSERVER}'. Supported: cli, octane, octane-watch."
  exit 1
  ;;
esac

echo "RUNNING WEBSERVER: ${SUPERVISOR_PHP_COMMAND}"

if [ "$#" -gt 0 ]; then
  exec "$@"
else
  exec /usr/bin/supervisord
fi
