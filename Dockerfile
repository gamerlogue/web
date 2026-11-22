# syntax=docker/dockerfile:1-labs
####
# DO NOT SET ARGS IN THIS FILE!
# Use the docker compose file to set the args.
####
###########################################
# Fresh editor: Alpine doesn't package it, so the static (musl) binary of its release.
# min-size build: no plugins, tree-sitter grammars or networking (update checks, telemetry).
###########################################
FROM alpine:3.24 AS fresh
RUN wget -qO- "https://github.com/sinelaw/fresh/releases/download/v0.5.8/fresh-min-size-$(uname -m)-unknown-linux-musl.tar.xz" \
    | tar -xJ -C /usr/local/bin --strip-components=1 "fresh-min-size-$(uname -m)-unknown-linux-musl/fresh"

###########################################
# Base Image (Some code from https://github.com/exaco/laravel-docktane)
###########################################
# Release-pinned tag, bumped by Renovate (versioning rule in renovate.json).
FROM serversideup/php:8.5-frankenphp-alpine-v5.1.2 AS base

USER root
RUN install-php-extensions apcu bcmath exif intl gd

LABEL maintainer="maicol07 <webmaster@maicol07.it>"
LABEL org.opencontainers.image.title="Gamerlogue web"
LABEL org.opencontainers.image.description="Web backend for Gamerlogue"
LABEL org.opencontainers.image.source=https://github.com/gamerlogue/web
LABEL org.opencontainers.image.licenses=MIT

ARG TZ=Europe/Rome

ENV APP_ENV=production \
    CADDY_ADMIN="localhost:2019" \
    CADDY_HTTP_PORT=80 \
    COMPOSER_FUND=0 \
    FORCE_COLOR=1 \
    OCTANE_SERVER=frankenphp \
    PHP_DATE_TIMEZONE=${TZ} \
    PHP_INI_SCAN_DIR=":$APP_BASE_DIR/deployment" \
    PHP_OPCACHE_ENABLE=1 \
    # v5 defaults to 0 (PHP files cached until restart); see deployment/DECISIONS.md.
    PHP_OPCACHE_VALIDATE_TIMESTAMPS=1 \
    PHP_REALPATH_CACHE_TTL=720 \
    TERM=xterm-color \
    TZ=${TZ} \
    USER=www-data

WORKDIR ${APP_BASE_DIR}

RUN apk add --no-cache --update \
    bash \
    fish \
    git \
    iputils \
    jq \
    mariadb-client \
    micro \
    nss-tools \
    tzdata \
    unzip \
    vim \
    wget \
    xh

COPY --from=fresh /usr/local/bin/fresh /usr/local/bin/fresh

# The image's Caddyfile imports these folders by glob; under Octane they are the only way in
# (CADDY_GLOBAL_OPTIONS is ignored, CADDY_SERVER_EXTRA_DIRECTIVES overwritten). Symlinks rather than
# copies: the targets come from the bind mount (dev) or `COPY . .` (prod).
RUN ln -s ${APP_BASE_DIR}/deployment/global.caddyfile /etc/frankenphp/caddyfile-global.d/global.caddyfile && \
    ln -s ${APP_BASE_DIR}/deployment/site.caddyfile /etc/frankenphp/caddyfile-server.d/site.caddyfile

# Setup User (Fish as default shell), Timezone & Permissions
RUN set -eux; \
    ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime; \
    echo ${TZ} > /etc/timezone; \
    mkdir -p /var/log/frankenphp && \
    chown ${USER} /var/log/frankenphp;

EXPOSE 80/tcp

###########################################
# Dev Image
###########################################
FROM base AS dev

ARG USER_ID=1000
ARG GROUP_ID=1000

ENV CADDY_AUTO_HTTPS=on \
    CADDY_HTTPS_PORT=443 \
    PHP_DISPLAY_ERRORS=1 \
    PHP_DISPLAY_STARTUP_ERRORS=1 \
    # PHPStan exhausts the 256M default while analysing the API Platform metadata
    PHP_MEMORY_LIMIT=1G \
    PHP_OPCACHE_REVALIDATE_FREQ=0 \
    SSL_MODE=full

USER root
RUN install-php-extensions xdebug

# Use the build arguments to change the UID
# and GID of www-data while also changing
# the file permissions for NGINX
RUN docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID && \
    \
    # Update the file permissions to match the new UID/GID \
    docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID && \
    chown ${USER} /var/log/frankenphp

# Install Dev specific helpers
COPY --from=oven/bun:1.4.3-alpine /usr/local/bin/bun /usr/local/bin/bunx /usr/local/bin/

# SSL Certs permissions for Sail/Local dev
RUN mkdir -p /etc/ssl/certs /usr/local/share/ca-certificates \
    && chown -R ${USER_ID}:${GROUP_ID} /etc/ssl/certs /usr/local/share/ca-certificates

# 1777 is what lets Xdebug create its own log file at runtime (XDEBUG_CONFIG log=/tmp/xdebug.log)
RUN rm -rf /tmp/* && chmod 1777 /tmp

USER ${USER}
WORKDIR ${APP_BASE_DIR}

EXPOSE 443/tcp 443/udp

###########################################
# Production Base
###########################################
FROM base AS prod-base
ARG USER_ID=82
ARG GROUP_ID=82

ENV AUTORUN_ENABLED=on \
    CADDY_ACCESS_LOG_OUTPUT=stdout \
    PHP_OPCACHE_JIT=tracing \
    PHP_OPCACHE_JIT_BUFFER_SIZE=64M

RUN mkdir -p /tmp/composer-cache /tmp/php-build \
    && chown -R ${USER} /tmp/composer-cache /tmp/php-build

USER ${USER}

COPY --chown=${USER} composer.json composer.lock ./

# Optimization: Use BuildKit cache mount for Composer
# This prevents re-downloading all deps if you change one package
RUN --mount=type=cache,target=/tmp/composer-cache,uid=${USER_ID},gid=${GROUP_ID}  \
    composer config --json audit.ignore-abandoned '["dragon-code/contracts", "dragon-code/pretty-array", "dragon-code/support"]' \
    && COMPOSER_CACHE_DIR=/tmp/composer-cache \
    TMPDIR=/tmp/php-build  \
    composer install \
    --no-dev \
    --no-interaction \
    --no-autoloader \
    --no-ansi \
    --no-scripts \
    --no-progress \
    --audit

COPY --chown=${USER} . .

RUN composer dump-autoload --optimize --apcu --no-dev --no-scripts

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Every artisan call below boots the application, and API Platform derives its routes from the
# Eloquent metadata it reads from the database: with no schema the item operations lose their {id},
# so package discovery and the generated Wayfinder routes would both be wrong. A throwaway sqlite
# database provides that schema, and the metadata dump carries it into the image so the running
# workers do not introspect the real database on every boot.
# DB_CONNECTION is scoped to these build-time Artisan calls so the runtime image can read it from
# the mounted .env file. Telescope defaults its own connection to mysql, so it needs the same override.
RUN export DB_CONNECTION=sqlite \
    && touch database/database.sqlite \
    && php artisan migrate --force \
    && php artisan package:discover --ansi \
    && php artisan vendor:publish --tag=api-platform-assets --force --no-interaction \
    && php artisan wayfinder:generate --path=resources/ts \
    && php artisan api-platform:metadata:dump \
    && rm database/database.sqlite

###########################################
# Frontend Build
###########################################
FROM oven/bun:1.4.4-alpine AS build
WORKDIR /app
COPY --link package.json bun.lock bunfig.toml ./

# Optimization: Use BuildKit cache mount for Bun cache
RUN --mount=type=cache,id=bun,target=/root/.bun/install/cache bun install --frozen-lockfile

COPY --link --parents resources lang vite.config.ts tsconfig.json ./
# Copy only necessary files for frontend build from PHP stage
COPY --from=prod-base --link /var/www/html/resources/ts/actions  ./resources/ts/actions
COPY --from=prod-base --link /var/www/html/resources/ts/routes  ./resources/ts/routes
COPY --from=prod-base --link /var/www/html/resources/ts/wayfinder  ./resources/ts/wayfinder
COPY --from=prod-base --link /var/www/html/vendor/emargareten/inertia-modal  ./vendor/emargareten/inertia-modal

RUN bun run build

###########################################
# Production Final
###########################################
FROM prod-base AS prod

COPY --chown=${USER} --from=build /app/public public

EXPOSE 80

# Same command as compose.prod.yaml, so an orchestrator running the image as-is (Kubernetes) gets
# Octane. `auto` is the host's CPU count, not the cgroup limit: set OCTANE_WORKERS per deployment.
CMD ["sh", "-c", "exec php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=80 --admin-port=2019 --workers=\"${OCTANE_WORKERS:-auto}\" --caddyfile=/etc/frankenphp/Caddyfile"]
