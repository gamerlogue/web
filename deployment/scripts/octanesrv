#!/bin/bash

# Script to start, stop or restart the Octane Server via supervisor
# Usage: ./octanesrv.sh {start|stop|restart|status}

SUPERVISORCTL=$(which supervisorctl)
if [ -z "$SUPERVISORCTL" ]; then
    echo "supervisorctl not found. Please ensure Supervisor is installed."
    exit 1
fi

# Get service name from `supervisorctl status` output (starts with `octane` or `php`)
SERVICE_NAME=$($SUPERVISORCTL status | awk '/^(octane|php)/ {print $1}')

case "$1" in
    start)
        echo "Starting $SERVICE_NAME..."
        $SUPERVISORCTL start $SERVICE_NAME
        ;;
    stop)
        echo "Stopping $SERVICE_NAME..."
        $SUPERVISORCTL stop $SERVICE_NAME
        ;;
    restart)
        echo "Restarting $SERVICE_NAME..."
        $SUPERVISORCTL restart $SERVICE_NAME
        ;;
    status)
        echo "Checking status of $SERVICE_NAME..."
        $SUPERVISORCTL status $SERVICE_NAME
        ;;
    *)
        echo "Usage: $0 {start|stop|restart|status}"
        exit 1
        ;;
esac
