# syntax=docker/dockerfile:1-labs
####
# DO NOT SET ARGS IN THIS FILE!
# Use the docker compose file to set the args.
####
ARG PHP_VERSION=8.4

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
    supervisor \
    supercronic \
    nodejs \
    npm \
    fish \
    expect \
    pnpm-fish-completion \
    pnpm-bash-completion

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions @composer apcu xdebug imagick gd imap zip bcmath intl exif redis opcache memcached pcntl pdo_mysql

ARG WWWUSER=sail
ARG WWWGROUP=sail
ARG UID=1000
ARG GID=1000

# Change ${WWWUSER} and ${WWWGROUP} ids to ${UID} and ${GID}
RUN adduser -s /usr/bin/fish -H -D -g ${WWWGROUP} -u ${UID} ${WWWUSER}

# Allow installing certs for sail to /etc/ssl/certs and /usr/local/share/ca-certificates
RUN mkdir -p /etc/ssl/certs /usr/local/share/ca-certificates \
    && chown -R ${UID}:${GID} /etc/ssl/certs /usr/local/share/ca-certificates

ENV PNPM_HOME="/pnpm"
ENV PATH="$PNPM_HOME:$PATH"
RUN npm install --global corepack@latest && corepack enable pnpm

ENV ROOT=/var/www/html \
    WITH_SCHEDULER=true \
    WITH_HORIZON=false

# Allow writing supervisor logs and pid file
RUN mkdir -p /var/log/supervisor \
    && touch /var/run/supervisord.pid \
    && chown -R ${UID}:${GID} /var/log/supervisor /var/run/supervisord.pid

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
HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD healthcheck || exit 1

USER ${UID}
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
    fish \
    expect \
    doas \
    doas-sudo-shim \
    iputils \
    micro \
    mycli \
    nss-tools \
    vim \
    tzdata \
    git \
    ncdu \
    procps \
    unzip \
    ca-certificates \
    supervisor \
    supercronic \
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
    igbinary \
    && docker-php-source delete \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

RUN mkdir -p /etc/supercronic \
    && echo "*/1 * * * * php ${ROOT}/artisan schedule:run --no-interaction" > /etc/supercronic/laravel

RUN echo "permit nopass :${USER}" > /etc/doas.d/20-web.conf
RUN addgroup -g ${GID} ${USER} \
    && adduser -D -h ${ROOT} -G ${USER} -u ${UID} -s /bin/sh ${USER} \
    && mkdir -p /home/${USER} \
    && chown -R ${USER}:${USER} /home/${USER} ${ROOT} \
    && \
    # Add additional capability to bind to port 80 and 443
    setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp && \
    setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/php;


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

COPY --link --chown=${UID}:${GID} composer.json composer.lock ./

RUN --mount=type=cache,target=.composer/cache composer install \
    --no-dev \
    --no-interaction \
    --optimize-autoloader \
    --prefer-dist \
    --no-scripts \
    --audit

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
ENV WAYFINDER_WORKAROUND=true

WORKDIR /app
COPY --link package.json pnpm-*.yaml ./
RUN npm install -g corepack && corepack enable pnpm

FROM build-base AS build
RUN --mount=type=cache,id=pnpm,target=/pnpm/store pnpm install --frozen-lockfile

COPY --link --parents resources vite.config.ts tsconfig.json ./
COPY --from=base --link --parents --chown=1000:1000 /var/www/html/resources/ts/actions /var/www/html/resources/ts/routes /var/www/html/resources/ts/wayfinder ./

RUN pnpm run build

###########################################

FROM base AS prod

USER ${USER}

ENV WITH_HORIZON=false \
    WITH_SCHEDULER=true \
    WITH_REVERB=false

COPY --link --chown=${UID}:${GID} --from=build /app/public public

EXPOSE 80
EXPOSE 2019

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD healthcheck || exit 1
