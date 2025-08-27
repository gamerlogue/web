#!/bin/sh
if [ "$SUPERVISOR_PHP_USER" != "root" ] && [ "$SUPERVISOR_PHP_USER" != "sail" ]; then
    echo "You should set SUPERVISOR_PHP_USER to either 'sail' or 'root'."
    exit 1
fi

# Ensure scheduler programs run as the same user as PHP in dev
export USER="$SUPERVISOR_PHP_USER"

# Install project package manager
corepack install

webserver=${WEBSERVER:-cli}
if [ "$webserver" = "cli" ]; then
  export SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=${SERVER_NAME:-0.0.0.0} --port=80"
  elif [ "$webserver" = "octane" ]; then
  export SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan octane:start --host=${SERVER_NAME:-0.0.0.0} --port=443 --admin-port=2019 --https"
  elif [ "$webserver" = "octane-watch" ]; then
  export SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan octane:start --watch --host=${SERVER_NAME:-0.0.0.0} --port=443 --admin-port=2019 --https"
fi
if [ $# -gt 0 ]; then
    exec "$@"
else
    exec /usr/bin/supervisord
fi
