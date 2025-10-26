# syntax=docker/dockerfile:1-labs
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

FROM php:${PHP_VERSION}-cli-alpine AS dev

# Install helpers
RUN apk add --no-cache \
    git \
    wget \
    supercronic \
    supervisor \
    nodejs \
    npm \
    fish \
    pnpm-fish-completion \
    pnpm-bash-completion

COPY --from=ghcr.io/mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions @composer apcu xdebug imagick gd imap zip bcmath intl exif redis opcache memcached pcntl pdo_mysql

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

# Allow writing supervisor logs and pid file
RUN mkdir -p /var/log/supervisor \
    && touch /var/run/supervisord.pid \
    && chown -R ${WWWUSER}:${WWWGROUP} /var/log/supervisor \
    && chown -R ${WWWUSER}:${WWWGROUP} /var/run/supervisord.pid

# Install supercronic for Laravel scheduler in dev
RUN mkdir -p /etc/supercronic \
    && echo "*/1 * * * * php ${ROOT}/artisan schedule:run --no-interaction" > /etc/supercronic/laravel

RUN ln -s /usr/local/bin/php /usr/bin/php
COPY deployment/dev/start-container-dev.sh /usr/local/bin/start-container
COPY deployment/dev/supervisord.dev.conf /etc/supervisor/conf.d/supervisord.conf
COPY --link --chown=${UID}:${UID} deployment/healthcheck /usr/local/bin/healthcheck
# Reuse prod scheduler/horizon config in dev to avoid duplication
COPY deployment/supervisord.conf /etc/supervisord.conf
COPY deployment/supervisord.scheduler.conf /etc/supervisor/conf.d/supervisord.scheduler.conf
COPY deployment/supervisord.horizon.conf /etc/supervisor/conf.d/supervisord.horizon.conf

RUN chmod +x /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container /usr/local/bin/healthcheck

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
HEALTHCHECK --start-period=5s --interval=10s --timeout=10s --retries=8 CMD healthcheck || exit 1

USER ${WWWUSER}
WORKDIR ${ROOT}

###########################################
# Derived from https://github.com/exaco/laravel-octane-dockerfile
###########################################
FROM dunglas/frankenphp:${FRANKENPHP_VERSION}-php${PHP_VERSION}-alpine AS base
ARG WWWUSER=1000
ARG WWWGROUP=1000
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
    XDG_DATA_HOME=${APP_DIR}/.data
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
    bash \
    fish \
    vim \
    tzdata \
    git \
    ncdu \
    procps \
    unzip \
    mycli \
    ca-certificates \
    supercronic \
    supervisor \
    libsodium-dev \
    brotli \
    # Install PHP extensions (included with dunglas/frankenphp) \
    && install-php-extensions \
    apcu \
    bz2 \
    pcntl \
    mbstring \
    bcmath \
    sockets \
    opcache \
    exif \
    pdo_mysql \
    zip \
    uv \
    vips \
    intl \
    gd \
    redis \
    memcached \
    igbinary \
    && docker-php-source delete \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

RUN mkdir -p /etc/supercronic \
    && echo "*/1 * * * * php ${ROOT}/artisan schedule:run --no-interaction" > /etc/supercronic/laravel

RUN addgroup -g ${WWWGROUP} ${USER} \
    && adduser -D -h ${ROOT} -G ${USER} -u ${WWWUSER} -s /bin/sh ${USER} \
    && setcap -r /usr/local/bin/frankenphp

RUN mkdir -p /var/log/supervisor /var/run/supervisor \
    && chown -R ${USER}:${USER} ${ROOT} /var/log /var/run \
    && chmod -R a+rw ${ROOT} /var/log /var/run

RUN cp ${PHP_INI_DIR}/php.ini-production ${PHP_INI_DIR}/php.ini

USER ${USER}

COPY --link --chown=${WWWUSER}:${WWWUSER} --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --link --chown=${WWWUSER}:${WWWUSER} deployment/supervisord.conf /etc/
COPY --link --chown=${WWWUSER}:${WWWUSER} deployment/supervisord.frankenphp.conf /etc/supervisor/conf.d/
COPY --link --chown=${WWWUSER}:${WWWUSER} deployment/supervisord.*.conf /etc/supervisor/conf.d/
COPY --link --chown=${WWWUSER}:${WWWUSER} deployment/start-container /usr/local/bin/start-container
COPY --link --chown=${WWWUSER}:${WWWUSER} deployment/healthcheck /usr/local/bin/healthcheck
COPY --link --chown=${WWWUSER}:${WWWUSER} deployment/php.ini ${PHP_INI_DIR}/conf.d/99-octane.ini

RUN chmod +x /usr/local/bin/start-container /usr/local/bin/healthcheck

COPY --link --chown=${WWWUSER}:${WWWUSER} . .

RUN composer install \
    --no-dev \
    --no-interaction \
    --optimize-autoloader \
    --prefer-dist \
    --audit \
    && composer clear-cache
RUN composer run post-root-package-install

###########################################
# Build frontend assets with PNPM
###########################################
FROM base AS build-base

USER root

RUN apk add --no-cache nodejs npm

ENV PNPM_HOME="/pnpm"
ENV PATH="$PNPM_HOME:$PATH"
ENV ROOT=/var/www/html

WORKDIR /app
RUN npm install -g corepack && corepack enable pnpm

FROM build-base AS build
COPY --link --parents=true package.json pnpm-*.yaml patches/* ./
RUN --mount=type=cache,id=pnpm,target=/pnpm/store pnpm install --frozen-lockfile

COPY --link --from=base ${ROOT}/vendor vendor
COPY --link . /app

RUN pnpm run build

###########################################

FROM base AS prod

USER ${USER}

ENV WITH_HORIZON=true \
    WITH_SCHEDULER=true \
    WITH_REVERB=false

COPY --link --chown=${WWWUSER}:${WWWUSER} --from=build /app/public public

RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/framework/testing \
    storage/logs \
    bootstrap/cache && chmod -R a+rw storage

EXPOSE 8000
EXPOSE 443
EXPOSE 443/udp
EXPOSE 2019
EXPOSE 8080

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=10s --timeout=10s --retries=8 CMD healthcheck || exit 1
