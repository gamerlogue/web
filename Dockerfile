# syntax=docker/dockerfile:1-labs
####
# DO NOT SET ARGS IN THIS FILE!
# Use the docker compose file to set the args.
####
ARG PHP_VERSION=8.5

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

###########################################
# Derived from https://github.com/exaco/laravel-docktane
###########################################
FROM dunglas/frankenphp:1-php${PHP_VERSION}-alpine AS base

LABEL maintainer="maicol07 <webmaster@maicol07.it>"
LABEL org.opencontainers.image.title="Gamerlogue web"
LABEL org.opencontainers.image.description="Web backend for Gamerlogue"
LABEL org.opencontainers.image.source=https://github.com/gamerlogue/web
LABEL org.opencontainers.image.licenses=MIT

ARG USER=laravel
ARG USER_ID=1000
ARG GROUP_ID=1000
ARG TZ=Europe/Rome
ARG APP_DIR=/var/www/html

ENV TERM=xterm-color \
    OCTANE_SERVER=frankenphp \
    TZ=${TZ} \
    USER=${USER} \
    ROOT=${APP_DIR} \
    APP_ENV=production \
    COMPOSER_FUND=0 \
    COMPOSER_MAX_PARALLEL_HTTP=48 \
    WITH_HORIZON=true \
    WITH_SCHEDULER=true \
    WITH_REVERB=false

WORKDIR ${ROOT}

SHELL ["/bin/sh", "-eou", "pipefail", "-c"]

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime \
    && echo ${TZ} > /etc/timezone

RUN apk update; \
    apk upgrade; \
    apk add --no-cache \
    curl \
    wget \
    httpie \
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

RUN mkdir -p /etc/supercronic \
    && echo "*/1 * * * * php ${ROOT}/artisan schedule:run --no-interaction" > /etc/supercronic/laravel

RUN addgroup -g ${GROUP_ID} ${USER} \
    && adduser -D -h ${ROOT} -G ${USER} -u ${USER_ID} -s /usr/bin/fish ${USER}

RUN mkdir -p /var/log/supervisor /var/run/supervisor \
    && chown -R ${USER}:${USER} ${ROOT} /var/log /var/run \
    && chmod -R a+rw ${ROOT} /var/log /var/run

COPY --link --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --link deployment/supervisord.conf /etc/
COPY --link deployment/healthcheck.sh /usr/local/bin/healthcheck
COPY --link deployment/scripts/* /usr/local/bin/
# Remove .sh extensions from scripts and chmod +x them
RUN for f in /usr/local/bin/*.sh; do mv "$f" "${f%.sh}"; chmod +x "${f%.sh}"; done;

RUN chmod +x /usr/local/bin/healthcheck
# Allow opcache file cache
RUN mkdir -p /tmp/opcache-file-cache && chown -R ${USER_ID}:${GROUP_ID} /tmp/opcache-file-cache

FROM base AS dev
ENV PHP_INI_SCAN_DIR="$PHP_INI_SCAN_DIR:${APP_DIR}/deployment:${APP_DIR}/deployment/dev" \
    XDG_CONFIG_HOME=/home/${USER}/.config \
    XDG_DATA_HOME=/home/${USER}/.local/share

# Install helpers
RUN apk add --no-cache \
    nodejs \
    npm \
    pnpm-fish-completion \
    pnpm-bash-completion

# Copy PHP extensions from ext-dev
COPY --from=ext-dev /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=ext-dev /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Create /home/${USER} and subfolders (so they are not owned by root when using volumes))
RUN mkdir -p /home/${USER} /home/${USER}/.cache /home/${USER}/.composer /home/${USER}/.local/share/caddy/pki/authorities \
    && chown -R ${USER}:${GROUP_ID} /home/${USER}

# Allow installing certs for sail to /etc/ssl/certs and /usr/local/share/ca-certificates
RUN mkdir -p /etc/ssl/certs /usr/local/share/ca-certificates \
    && chown -R ${USER}:${GROUP_ID} /etc/ssl/certs /usr/local/share/ca-certificates

RUN npm install --global corepack@latest && corepack enable pnpm

COPY deployment/dev/start-container-dev.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

COPY deployment/dev/supervisord.dev.conf /etc/supervisor/conf.d/supervisord.conf
# Reuse prod scheduler/horizon config in dev to avoid duplication
COPY deployment/supervisord.conf /etc/supervisord.conf
COPY deployment/supervisord.scheduler.conf /etc/supervisor/conf.d/supervisord.scheduler.conf
COPY deployment/supervisord.horizon.conf /etc/supervisor/conf.d/supervisord.horizon.conf

USER ${USER}
WORKDIR ${ROOT}

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
HEALTHCHECK --start-period=5s --interval=10s --timeout=10s --retries=8 CMD healthcheck || exit 1

FROM base AS prod-base
ENV XDG_CONFIG_HOME=${ROOT}/.config XDG_DATA_HOME=${ROOT}/.data

# Copy PHP extensions from ext-builder
COPY --from=ext-builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=ext-builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

RUN cp ${PHP_INI_DIR}/php.ini-production ${PHP_INI_DIR}/php.ini

COPY --link deployment/start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

COPY --link deployment/php.ini ${PHP_INI_DIR}/conf.d/99-php.ini

COPY --link deployment/supervisord.*.conf /etc/supervisor/conf.d/
COPY --link deployment/supervisord.frankenphp.conf /etc/supervisor/conf.d/

COPY --link composer.* ./

RUN --mount=type=cache,target=/home/${USER}/.composer/cache,uid=${USER_ID},gid=${GROUP_ID} composer install \
    --no-dev \
    --no-interaction \
    --no-autoloader \
    --no-ansi \
    --no-scripts \
    --no-progress \
    --audit

COPY --link . .

RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/framework/testing \
    storage/logs \
    bootstrap/cache \
    && chown -R ${USER_ID}:${GROUP_ID} ${ROOT}

USER ${USER}

RUN touch database/database.sqlite

RUN composer dump-autoload \
    --optimize \
    --apcu \
    --no-dev

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
COPY --from=prod-base --link /var/www/html/resources/ts/actions  ./resources/ts/actions
COPY --from=prod-base --link /var/www/html/resources/ts/routes  ./resources/ts/routes
COPY --from=prod-base --link /var/www/html/resources/ts/wayfinder  ./resources/ts/wayfinder
COPY --from=prod-base --link /var/www/html/vendor/emargareten/inertia-modal  ./vendor/emargareten/inertia-modal

RUN pnpm run build

###########################################
FROM prod-base AS prod

USER ${USER}

COPY --link --chown=${USER_ID}:${GROUP_ID} --from=build /app/public public

RUN php artisan vendor:publish --tag=log-viewer-assets --force

EXPOSE 80
EXPOSE 2019

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=1s --timeout=3s --retries=10 CMD healthcheck || exit 1
