#!/usr/bin/env sh

set -e

container_mode=${CONTAINER_MODE:-"http"}

health_fail() {
  echo "Healthcheck failed."
  exit 1
}

supervisor_is_running() {
  name="$1"
  # Extract the status (2nd column), normalize it to lowercase and compare with "running"
  status=$(supervisorctl status "$name" | awk '{print tolower($2)}')
  [ "$status" = "running" ]
}

case "${container_mode}" in
http)
  php "${ROOT}/artisan" octane:status
  ;;
horizon)
  php "${ROOT}/artisan" horizon:status
  ;;
scheduler)
  supervisor_is_running "scheduler:scheduler_0" || health_fail
  ;;
reverb)
  supervisor_is_running "reverb:reverb_0" || health_fail
  ;;
worker)
  supervisor_is_running "worker:worker_0" || health_fail
  ;;
*)
  echo "Container mode mismatched."
  exit 1
  ;;
esac
