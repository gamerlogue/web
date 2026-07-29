# syntax=docker/dockerfile:1-labs
####
# DO NOT SET ARGS IN THIS FILE!
# Use the docker compose file to set the args.
####
ARG PHP_VERSION=8.5

###########################################
# Base Image (Some code from https://github.com/exaco/laravel-docktane)
###########################################
FROM ghcr.io/maicol07/docker-php-dev:${PHP_VERSION}-frankenphp-alpine AS base

USER root
RUN install-php-extensions apcu bcmath exif intl gd

ARG TZ=Europe/Rome

ENV APP_ENV=production \
    CADDY_ADMIN=":2019" \
    CADDY_HTTP_PORT=80 \
    COMPOSER_FUND=0 \
    OCTANE_SERVER=frankenphp \
    PHP_DATE_TIMEZONE=${TZ} \
    PHP_INI_SCAN_DIR=":$APP_BASE_DIR/deployment" \
    PHP_OPCACHE_ENABLE=1 \
    PHP_OPCACHE_INTERNED_STRINGS_BUFFER=16 \
    PHP_OPCACHE_MAX_ACCELERATED_FILES=32531 \
    PHP_OPCACHE_MEMORY_CONSUMPTION=256 \
    PHP_REALPATH_CACHE_TTL=720 \
    TERM=xterm-color \
    TZ=${TZ} \
    USER=www-data

WORKDIR ${APP_BASE_DIR}

RUN apk add --no-cache --update \
    bash \
    expect \
    fish \
    git \
    iputils \
    mariadb-client \
    micro \
    nss-tools \
    tzdata \
    unzip \
    vim \
    wget \
    xh

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
COPY --from=oven/bun:alpine /usr/local/bin/bun /usr/local/bin/bunx /usr/local/bin/

RUN touch /tmp/xdebug.log && chmod 666 /tmp/xdebug.log

# SSL Certs permissions for Sail/Local dev
RUN mkdir -p /etc/ssl/certs /usr/local/share/ca-certificates \
    && chown -R ${USER}:${GROUP_ID} /etc/ssl/certs /usr/local/share/ca-certificates

RUN rm -rf /tmp/* && chmod 1777 /tmp

USER ${USER}
WORKDIR ${APP_BASE_DIR}

EXPOSE 443/tcp 443/udp 2019/tcp

###########################################
# Production Base
###########################################
FROM base AS prod-base
ARG USER_ID=82
ARG GROUP_ID=82

ENV AUTORUN_ENABLED=on \
    PHP_OPCACHE_JIT=tracing \
    PHP_OPCACHE_JIT_BUFFER_SIZE=64M

RUN mkdir -p /tmp/composer-cache /tmp/php-build \
    && chown -R ${USER} /tmp/composer-cache /tmp/php-build \
    && chmod 777 /tmp/composer-cache /tmp/php-build

USER ${USER}

COPY --chown=${USER} composer.json composer.lock ./

# Optimization: Use BuildKit cache mount for Composer
# This prevents re-downloading all deps if you change one package
RUN --mount=type=cache,target=/tmp/composer-cache,uid=${USER_ID},gid=${GROUP_ID}  \
    COMPOSER_CACHE_DIR=/tmp/composer-cache \
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

# Build-time operations (needs dummy DB)
RUN touch database/database.sqlite \
    && DB_CONNECTION=sqlite php artisan migrate --force \
    && composer run post-autoload-dump \
    && php artisan wayfinder:generate --path=resources/ts \
    && php artisan optimize:clear \
    && php artisan cache:clear file

###########################################
# Frontend Build
###########################################
FROM oven/bun:alpine AS build
WORKDIR /app
COPY --link package.json bun.lock bunfig.toml ./

# Optimization: Use BuildKit cache mount for Bun cache
RUN --mount=type=cache,id=bun,target=/root/.bun/install/cache bun install --frozen-lockfile

COPY --link --parents resources lang vite.config.ts tsconfig.json ./
# Copy only necessary files for frontend build from PHP stage
COPY --from=prod-base --link /var/www/html/resources/ts/actions  ./resources/ts/actions
COPY --from=prod-base --link /var/www/html/resources/ts/routes  ./resources/ts/routes
COPY --from=prod-base --link /var/www/html/resources/ts/wayfinder  ./resources/ts/wayfinder
#COPY --from=prod-base --link /var/www/html/vendor/emargareten/inertia-modal  ./vendor/emargareten/inertia-modal

RUN bun run build

###########################################
# Production Final
###########################################
FROM prod-base AS prod

USER root
RUN rm -rf /tmp/* && chmod 1777 /tmp

USER ${USER}

COPY --chown=${USER} --from=build /app/public public

# Final cleanup and asset publishing
RUN php artisan vendor:publish --tag=log-viewer-assets --force && \
    php artisan vendor:publish --tag=api-platform-assets --force && \
    rm -f database/database.sqlite

EXPOSE 80 2019
