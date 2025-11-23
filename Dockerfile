# syntax=docker/dockerfile:1-labs
####
# DO NOT SET ARGS IN THIS FILE!
# Use the docker compose file to set the args.
####
ARG PHP_VERSION=8.4
ARG FRANKENPHP_VERSION=1.9.1

FROM dunglas/frankenphp:1-builder-php${PHP_VERSION}-alpine AS builder

# Copy xcaddy in the builder image
COPY --from=caddy:builder /usr/bin/xcaddy /usr/bin/xcaddy

# CGO must be enabled to build FrankenPHP
RUN CGO_ENABLED=1 \
    XCADDY_SETCAP=1 \
    XCADDY_GO_BUILD_FLAGS="-ldflags='-w -s' -tags=nobadger,nomysql,nopgx" \
    CGO_CFLAGS=$(php-config --includes) \
    CGO_LDFLAGS="$(php-config --ldflags) $(php-config --libs)" \
    xcaddy build \
        --output /usr/local/bin/frankenphp \
        --with github.com/dunglas/frankenphp=./ \
        --with github.com/dunglas/frankenphp/caddy=./caddy/ \
        --with github.com/dunglas/caddy-cbrotli \
        --with github.com/caddyserver/transform-encoder

FROM php:${PHP_VERSION}-zts-alpine AS ext-builder
# Install build dependencies
RUN apk add --no-cache \
    autoconf \
    automake \
    g++ \
    git \
    icu-dev \
    linux-headers \
    libpng-dev \
    libtool \
    make \
    m4 \
    oniguruma-dev \
    pkgconf \
    libzip-dev \
    wget

COPY --from=ghcr.io/php/pie:bin /pie /usr/bin/pie

RUN set -eux; \
    exts="apcu/apcu phpredis/phpredis"; \
    for ext in $exts; do \
        pie install $ext; \
    done;

# Install and enable bundled extensions
RUN set -eux; \
    bundledexts="bcmath intl exif gd mbstring opcache pcntl pdo_mysql zip"; \
    for ext in $bundledexts; do \
        docker-php-ext-install $ext; \
    done; \
    docker-php-source delete

FROM ext-builder AS ext-dev
RUN pie install xdebug/xdebug

FROM php:${PHP_VERSION}-zts-alpine AS dev

# Install helpers
RUN apk add --no-cache \
    expect \
    fish \
    git \
    libpng \
    libzip \
    nodejs \
    npm \
    supervisor \
    supercronic \
    pnpm-fish-completion \
    pnpm-bash-completion \
    wget

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy PHP extensions from ext-dev
COPY --from=ext-dev /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=ext-dev /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

ARG WWWUSER=sail
ARG WWWGROUP=sail
ARG UID=1000
ARG GID=1000

# Change ${WWWUSER} and ${WWWGROUP} ids to ${UID} and ${GID}
RUN adduser -s /usr/bin/fish -H -D -g ${WWWGROUP} -u ${UID} ${WWWUSER}
# Create /home/${WWWUSER} and subfolders (so they are not owned by root when using volumes)
RUN mkdir -p /home/${WWWUSER} /home/${WWWUSER}/.cache /home/${WWWUSER}/.composer /home/${WWWUSER}/.local/share/caddy/pki/authorities \
    && chown -R ${WWWUSER}:${WWWGROUP} /home/${WWWUSER}

# Allow installing certs for sail to /etc/ssl/certs and /usr/local/share/ca-certificates
RUN mkdir -p /etc/ssl/certs \
    && mkdir -p /usr/local/share/ca-certificates \
    && chown -R ${WWWUSER}:${WWWGROUP} /etc/ssl/certs \
    && chown -R ${WWWUSER}:${WWWGROUP} /usr/local/share/ca-certificates

RUN npm install --global corepack@latest && corepack enable pnpm

ENV ROOT=/var/www/html \
    WITH_SCHEDULER=true \
    WITH_HORIZON=true

ENV PHP_INI_SCAN_DIR="$PHP_INI_SCAN_DIR:$ROOT/deployment"

# Allow writing supervisor logs and pid file
RUN mkdir -p /var/log/supervisor \
    && touch /var/run/supervisord.pid \
    && chown -R ${WWWUSER}:${WWWGROUP} /var/log/supervisor \
    && chown -R ${WWWUSER}:${WWWGROUP} /var/run/supervisord.pid

# Setup supercronic for Laravel scheduler in dev
RUN mkdir -p /etc/supercronic \
    && echo "*/1 * * * * php ${ROOT}/artisan schedule:run --no-interaction" > /etc/supercronic/laravel

RUN ln -s /usr/local/bin/php /usr/bin/php
COPY deployment/dev/start-container-dev.sh /usr/local/bin/start-container
COPY deployment/dev/supervisord.dev.conf /etc/supervisor/conf.d/supervisord.conf
COPY --link --chown=${UID}:${GID} deployment/healthcheck /usr/local/bin/healthcheck
# Reuse prod scheduler/horizon config in dev to avoid duplication
COPY deployment/supervisord.conf /etc/supervisord.conf
COPY deployment/supervisord.scheduler.conf /etc/supervisor/conf.d/supervisord.scheduler.conf
COPY deployment/supervisord.horizon.conf /etc/supervisor/conf.d/supervisord.horizon.conf

RUN chmod +x /usr/local/bin/start-container /usr/local/bin/healthcheck

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
HEALTHCHECK --start-period=5s --interval=10s --timeout=10s --retries=8 CMD healthcheck || exit 1

USER ${WWWUSER}
WORKDIR ${ROOT}

###########################################
# Derived from https://github.com/exaco/laravel-octane-dockerfile
###########################################
FROM dunglas/frankenphp:1-php${PHP_VERSION}-alpine AS base
ARG UID=1000
ARG GID=1000
ARG TZ=Europe/Rome
ARG APP_DIR=/var/www/html

ENV TERM=xterm-color \
    OCTANE_SERVER=frankenphp \
    TZ=${TZ} \
    USER=octane \
    ROOT=${APP_DIR} \
    APP_ENV=production \
    COMPOSER_FUND=0 \
    COMPOSER_MAX_PARALLEL_HTTP=24 \
    XDG_CONFIG_HOME=${APP_DIR}/.config \
    XDG_DATA_HOME=${APP_DIR}/.data \
    PHP_INI_SCAN_DIR="$PHP_INI_SCAN_DIR:${APP_DIR}/deployment"
WORKDIR ${ROOT}

# Replace the official binary by the one contained your custom modules
COPY --from=builder /usr/local/bin/frankenphp /usr/local/bin/frankenphp

SHELL ["/bin/sh", "-eou", "pipefail", "-c"]

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime \
    && echo ${TZ} > /etc/timezone

RUN apk update; \
    apk upgrade; \
    apk add --no-cache \
    curl \
    wget \
    fish \
    expect \
    icu \
    iputils \
    libjpeg-turbo \
    libpng \
    libzip \
    micro \
    nss-tools \
    vim \
    tzdata \
    git \
    ncurses \
    procps \
    unzip \
    mycli \
    ca-certificates \
    supercronic \
    supervisor \
    libsodium-dev \
    brotli \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*


# Copy PHP extensions from ext-builder
COPY --from=ext-builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=ext-builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

RUN mkdir -p /etc/supercronic \
    && echo "*/1 * * * * php ${ROOT}/artisan schedule:run --no-interaction" > /etc/supercronic/laravel

RUN addgroup -g ${GID} ${USER} \
    && adduser -D -h ${ROOT} -G ${USER} -u ${UID} -s /bin/sh ${USER} \
    && setcap -r /usr/local/bin/frankenphp

RUN mkdir -p /var/log/supervisor /var/run/supervisor \
    && chown -R ${USER}:${USER} ${ROOT} /var/log /var/run \
    && chmod -R a+rw ${ROOT} /var/log /var/run

RUN cp ${PHP_INI_DIR}/php.ini-production ${PHP_INI_DIR}/php.ini

USER ${USER}

COPY --link --chown=${UID}:${GID} --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --link --chown=${UID}:${GID} deployment/supervisord.conf /etc/
COPY --link --chown=${UID}:${GID} deployment/supervisord.frankenphp.conf /etc/supervisor/conf.d/
COPY --link --chown=${UID}:${GID} deployment/supervisord.*.conf /etc/supervisor/conf.d/
COPY --link --chown=${UID}:${GID} deployment/start-container /usr/local/bin/start-container
COPY --link --chown=${UID}:${GID} deployment/healthcheck /usr/local/bin/healthcheck
COPY --link --chown=${UID}:${GID} deployment/php.ini ${PHP_INI_DIR}/conf.d/99-octane.ini

RUN chmod +x /usr/local/bin/start-container /usr/local/bin/healthcheck

COPY --link --chown=${UID}:${GID} . .

RUN --mount=type=cache,target=/home/sail/.composer/cache,uid=${UID},gid=${GID} composer install \
    --no-dev \
    --no-interaction \
    --optimize-autoloader \
    --prefer-dist \
    --no-scripts \
    --audit

RUN composer clear-cache

RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/framework/testing \
    storage/logs \
    bootstrap/cache && chmod -R a+rw storage

COPY --link --chown=${UID}:${UID} . .

RUN composer run post-autoload-dump
RUN php artisan wayfinder:generate --path=resources/ts

###########################################
# Build frontend assets with PNPM
###########################################
FROM node:24-alpine AS build-base
ENV PNPM_HOME="/pnpm"
ENV PATH="$PNPM_HOME:$PATH"
ENV ROOT=/var/www/html

WORKDIR /app
COPY --link package.json pnpm-*.yaml ./
RUN npm install -g corepack && corepack enable pnpm

FROM build-base AS build
COPY --link --parents patches ./

RUN --mount=type=cache,id=pnpm,target=/pnpm/store pnpm install --frozen-lockfile

COPY --link --parents resources lang vite.config.ts tsconfig.json ./
COPY --from=base --link --chown=1000:1000 /var/www/html/resources/ts/actions  ./resources/ts/actions
COPY --from=base --link --chown=1000:1000 /var/www/html/resources/ts/routes  ./resources/ts/routes
COPY --from=base --link --chown=1000:1000 /var/www/html/resources/ts/wayfinder  ./resources/ts/wayfinder
COPY --from=base --link --chown=1000:1000 /var/www/html/vendor/emargareten/inertia-modal  ./vendor/emargareten/inertia-modal

RUN pnpm run build

###########################################

FROM base AS prod

USER ${USER}

ENV WITH_HORIZON=true \
    WITH_SCHEDULER=true \
    WITH_REVERB=false

COPY --link --chown=${UID}:${GID} --from=build /app/public public
RUN php artisan vendor:publish --tag=log-viewer-assets --force

EXPOSE 80
EXPOSE 2019

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=10s --timeout=10s --retries=8 CMD healthcheck || exit 1
