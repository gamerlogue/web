# syntax=docker/dockerfile:1-labs
####
# DO NOT SET ARGS IN THIS FILE!
# Use the docker compose file to set the args.
####
ARG PHP_VERSION=8.5

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
    bundledexts="bcmath intl exif gd mbstring pcntl pdo_mysql zip"; \
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
ARG USER_ID=1000
ARG GROUP_ID=1000

# Change ${WWWUSER} and ${WWWGROUP} ids to ${USER_ID} and ${GROUP_ID}
RUN adduser -s /usr/bin/fish -H -D -g ${WWWGROUP} -u ${USER_ID} ${WWWUSER}
# Create /home/${WWWUSER} and subfolders (so they are not owned by root when using volumes)
RUN mkdir -p /home/${WWWUSER} /home/${WWWUSER}/.cache /home/${WWWUSER}/.composer /home/${WWWUSER}/.local/share/caddy/pki/authorities \
    && chown -R ${WWWUSER}:${WWWGROUP} /home/${WWWUSER}

# Allow installing certs for sail to /etc/ssl/certs and /usr/local/share/ca-certificates
RUN mkdir -p /etc/ssl/certs /usr/local/share/ca-certificates \
    && chown -R ${WWWUSER}:${WWWGROUP} /etc/ssl/certs /usr/local/share/ca-certificates

RUN npm install --global corepack@latest && corepack enable pnpm

ENV ROOT=/var/www/html \
    WITH_SCHEDULER=true \
    WITH_HORIZON=true

ENV PHP_INI_SCAN_DIR="$PHP_INI_SCAN_DIR:$ROOT/deployment"

# Allow writing supervisor logs and pid file
RUN mkdir -p /var/log/supervisor \
    && touch /var/run/supervisord.pid \
    && chown -R ${WWWUSER}:${WWWGROUP} /var/log/supervisor /var/run/supervisord.pid

# Setup supercronic for Laravel scheduler in dev
RUN mkdir -p /etc/supercronic \
    && echo "*/1 * * * * php ${ROOT}/artisan schedule:run --no-interaction" > /etc/supercronic/laravel

RUN ln -s /usr/local/bin/php /usr/bin/php
COPY deployment/dev/start-container-dev.sh /usr/local/bin/start-container
COPY deployment/dev/supervisord.dev.conf /etc/supervisor/conf.d/supervisord.conf
COPY --link deployment/healthcheck.sh /usr/local/bin/healthcheck
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
# Derived from https://github.com/exaco/laravel-docktane
###########################################
FROM dunglas/frankenphp:1-php${PHP_VERSION}-alpine AS base

COPY --from=builder /usr/local/bin/frankenphp /usr/local/bin/frankenphp

LABEL maintainer="maicol07 <webmaster@maicol07.it>"
LABEL org.opencontainers.image.title="Gamerlogue web"
LABEL org.opencontainers.image.description="Web backend for Gamerlogue"
LABEL org.opencontainers.image.source=https://github.com/gamerlogue/web
LABEL org.opencontainers.image.licenses=MIT

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG TZ=Europe/Rome
ARG APP_DIR=/var/www/html

ENV TERM=xterm-color \
    OCTANE_SERVER=frankenphp \
    TZ=${TZ} \
    USER=laravel \
    ROOT=${APP_DIR} \
    APP_ENV=production \
    COMPOSER_FUND=0 \
    COMPOSER_MAX_PARALLEL_HTTP=48 \
    WITH_HORIZON=true \
    WITH_SCHEDULER=true \
    WITH_REVERB=false \
    PHP_INI_SCAN_DIR="$PHP_INI_SCAN_DIR:${APP_DIR}/deployment"

ENV XDG_CONFIG_HOME=${ROOT}/.config XDG_DATA_HOME=${ROOT}/.data

WORKDIR ${ROOT}

SHELL ["/bin/sh", "-eou", "pipefail", "-c"]

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime \
    && echo ${TZ} > /etc/timezone

RUN apk update; \
    apk upgrade; \
    apk add --no-cache \
    curl \
    wget \
    bash \
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
    libsodium-dev \
    brotli

# Workaround for https://gitlab.alpinelinux.org/alpine/aports/-/issues/17391
RUN apk add --no-cache supervisor --repository=https://dl-cdn.alpinelinux.org/alpine/edge/main \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

# Copy PHP extensions from ext-builder
COPY --from=ext-builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=ext-builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

RUN mkdir -p /etc/supercronic \
    && echo "*/1 * * * * php ${ROOT}/artisan schedule:run --no-interaction" > /etc/supercronic/laravel

RUN addgroup -g ${GROUP_ID} ${USER} \
    && adduser -D -h ${ROOT} -G ${USER} -u ${USER_ID} -s /bin/fish ${USER}

RUN mkdir -p /var/log/supervisor /var/run/supervisor \
    && chown -R ${USER}:${USER} ${ROOT} /var/log /var/run \
    && chmod -R a+rw ${ROOT} /var/log /var/run

RUN cp ${PHP_INI_DIR}/php.ini-production ${PHP_INI_DIR}/php.ini

COPY --link --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --link deployment/supervisord.conf /etc/
COPY --link deployment/supervisord.frankenphp.conf /etc/supervisor/conf.d/
COPY --link deployment/supervisord.*.conf /etc/supervisor/conf.d/
COPY --link deployment/start-container.sh /usr/local/bin/start-container
COPY --link deployment/healthcheck.sh /usr/local/bin/healthcheck
COPY --link deployment/php.ini ${PHP_INI_DIR}/conf.d/99-php.ini
COPY --link composer.* ./

RUN chmod +x /usr/local/bin/start-container /usr/local/bin/healthcheck

RUN --mount=type=cache,target=/home/${WWWUSER}/.composer/cache,uid=${USER_ID},gid=${GROUP_ID} composer install \
    --no-dev \
    --no-interaction \
    --no-autoloader \
    --no-ansi \
    --no-scripts \
    --no-progress \
    --audit

RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/framework/testing \
    storage/logs \
    bootstrap/cache \
    && chown -R ${USER_ID}:${GROUP_ID} ${ROOT} \
    && chmod +x /usr/local/bin/start-container /usr/local/bin/healthcheck

RUN composer dump-autoload \
    --optimize \
    --apcu \
    --no-dev

RUN composer clear-cache

COPY --link --chown=${USER_ID}:${USER_ID} . .

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
COPY --from=base --link /var/www/html/resources/ts/actions  ./resources/ts/actions
COPY --from=base --link /var/www/html/resources/ts/routes  ./resources/ts/routes
COPY --from=base --link /var/www/html/resources/ts/wayfinder  ./resources/ts/wayfinder
COPY --from=base --link /var/www/html/vendor/emargareten/inertia-modal  ./vendor/emargareten/inertia-modal

RUN pnpm run build

###########################################

FROM base AS prod

USER ${USER}

COPY --link --chown=${USER_ID}:${GROUP_ID} --from=build /app/public public

RUN php artisan vendor:publish --tag=log-viewer-assets --force

EXPOSE 80
EXPOSE 2019

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=1s --timeout=3s --retries=10 CMD healthcheck || exit 1
