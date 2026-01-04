# syntax=docker/dockerfile:1-labs
####
# DO NOT SET ARGS IN THIS FILE!
# Use the docker compose file to set the args.
####
ARG PHP_VERSION=8.5

###########################################
# Extension Builder
###########################################
FROM php:${PHP_VERSION}-zts-alpine AS ext-builder

# Install build dependencies (combined in one layer and using virtual package for easier cleanup if needed)
RUN apk add --no-cache --virtual .build-deps \
    autoconf automake g++ git icu-dev linux-headers \
    libpng-dev libtool make m4 oniguruma-dev \
    pkgconf libzip-dev wget

COPY --from=ghcr.io/php/pie:bin /pie /usr/bin/pie

# Install PIE extensions
RUN set -eux; \
    exts="apcu/apcu phpredis/phpredis"; \
    for ext in $exts; do \
        pie install $ext; \
    done;

# Install Bundled extensions & cleanup
RUN set -eux; \
    docker-php-ext-install bcmath intl exif gd mbstring pcntl pdo_mysql zip; \
    docker-php-source delete; \
apk add --no-cache libpng icu-libs libzip;

###########################################
# Extension Prod
###########################################
FROM ext-builder AS ext-prod
RUN apk del .build-deps

###########################################
# Extension Dev (Xdebug)
###########################################
FROM ext-builder AS ext-dev
RUN pie install xdebug/xdebug && apk del .build-deps

###########################################
# Base Image (Derived from https://github.com/exaco/laravel-docktane)
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

RUN apk add --no-cache --update \
    bash \
    brotli \
    ca-certificates \
    curl \
    expect \
    file \
    fish \
    git \
    httpie \
    icu-libs \
    iputils \
    libjpeg-turbo \
    libpng \
    libsodium \
    libzip \
    micro \
    mycli \
    ncurses \
    nss-tools \
    procps \
    supercronic \
    supervisor \
    tzdata \
    unzip \
    vim \
    wget

# Setup User (Fish as default shell), Timezone & Permissions
RUN set -eux; \
    ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime; \
    echo ${TZ} > /etc/timezone; \
    addgroup -g ${GROUP_ID} ${USER}; \
    adduser -D -h ${ROOT} -G ${USER} -u ${USER_ID} -s /usr/bin/fish ${USER}; \
    mkdir -p /etc/supercronic /var/log/supervisor /var/run/supervisor /tmp/opcache-file-cache; \
    echo "*/1 * * * * php ${ROOT}/artisan schedule:run --no-interaction" > /etc/supercronic/laravel; \
    chmod 1777 /tmp; \
    chown -R ${USER}:${USER} /var/log /var/run /tmp/opcache-file-cache; \
    chmod -R 775 /var/log /var/run;

COPY --link --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --link deployment/supervisord.conf /etc/
COPY --link deployment/healthcheck.sh /usr/local/bin/healthcheck

COPY --link deployment/scripts/* /tmp/scripts/
RUN set -eux; \
    for f in /tmp/scripts/*.sh; do mv "$f" "/usr/local/bin/$(basename "$f" .sh)"; done; \
    chmod +x /usr/local/bin/*; \
    rm -rf /tmp/scripts

###########################################
# Dev Image
###########################################
FROM base AS dev
ENV PHP_INI_SCAN_DIR="$PHP_INI_SCAN_DIR:${APP_DIR}/deployment:${APP_DIR}/deployment/dev" \
    XDG_CONFIG_HOME=/home/${USER}/.config \
    XDG_DATA_HOME=/home/${USER}/.local/share

# Install Dev specific helpers (doas instead of sudo for Alpine)
RUN apk add --no-cache \
    doas \
    doas-sudo-shim \
    nodejs \
    npm \
    pnpm-fish-completion \
    pnpm-bash-completion

# Copy PHP extensions from ext-dev
COPY --from=ext-dev /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=ext-dev /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Setup home directories (so they are not owned by root when using volumes)
RUN mkdir -p /home/${USER} /home/${USER}/.cache /home/${USER}/.composer /home/${USER}/.local/share/caddy/pki/authorities \
    && chown -R ${USER}:${GROUP_ID} /home/${USER} \
    && echo "permit nopass :${USER}" > /etc/doas.d/20-web.conf \
    && touch /tmp/xdebug.log && chmod 666 /tmp/xdebug.log

# SSL Certs permissions for Sail/Local dev
RUN mkdir -p /etc/ssl/certs /usr/local/share/ca-certificates \
    && chown -R ${USER}:${GROUP_ID} /etc/ssl/certs /usr/local/share/ca-certificates

RUN npm install --global corepack@latest && corepack enable pnpm

COPY deployment/dev/start-container-dev.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

# Supervisor Configs for Dev
COPY deployment/dev/supervisord.dev.conf /etc/supervisor/conf.d/supervisord.conf
COPY deployment/supervisord.conf /etc/supervisord.conf
COPY deployment/supervisord.scheduler.conf /etc/supervisor/conf.d/supervisord.scheduler.conf
COPY deployment/supervisord.horizon.conf /etc/supervisor/conf.d/supervisord.horizon.conf

USER ${USER}
WORKDIR ${ROOT}

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
HEALTHCHECK --start-period=5s --interval=10s --timeout=10s --retries=8 CMD healthcheck || exit 1

###########################################
# Production Base
###########################################
FROM base AS prod-base
ENV XDG_CONFIG_HOME=${ROOT}/.config XDG_DATA_HOME=${ROOT}/.data

# Copy PHP extensions from ext-builder
COPY --from=ext-prod /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=ext-prod /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# PHP & Supervisor Configs
RUN cp ${PHP_INI_DIR}/php.ini-production ${PHP_INI_DIR}/php.ini
COPY --link deployment/php.ini ${PHP_INI_DIR}/conf.d/99-php.ini
COPY --link deployment/supervisord.*.conf /etc/supervisor/conf.d/
COPY --link deployment/supervisord.frankenphp.conf /etc/supervisor/conf.d/
COPY --link deployment/start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

RUN mkdir -p /tmp/composer-cache /tmp/php-build \
    && chown -R ${USER_ID}:${GROUP_ID} /tmp/composer-cache /tmp/php-build \
    && chmod 777 /tmp/composer-cache /tmp/php-build

USER ${USER}

COPY --link --chown=${USER_ID}:${GROUP_ID} composer.json composer.lock ./

# Optimization: Use BuildKit cache mount for Composer
# This prevents re-downloading all deps if you change one package
RUN --mount=type=cache,target=/tmp/composer-cache,uid=$USER_ID,gid=$GROUP_ID  \
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

COPY --link --chown=${USER_ID}:${GROUP_ID} . .

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
FROM node:24-alpine AS build-base
ENV PNPM_HOME="/pnpm" PATH="$PNPM_HOME:$PATH" ROOT=/var/www/html
WORKDIR /app
COPY --link package.json pnpm-*.yaml ./
RUN npm install -g corepack && corepack enable pnpm

FROM build-base AS build
COPY --link --parents patches ./

# Optimization: Use BuildKit cache mount for PNPM store
RUN --mount=type=cache,id=pnpm,target=/pnpm/store pnpm install --frozen-lockfile

COPY --link --parents resources lang vite.config.ts tsconfig.json ./
# Copy only necessary files for frontend build from PHP stage
COPY --from=prod-base --link /var/www/html/resources/ts/actions  ./resources/ts/actions
COPY --from=prod-base --link /var/www/html/resources/ts/routes  ./resources/ts/routes
COPY --from=prod-base --link /var/www/html/resources/ts/wayfinder  ./resources/ts/wayfinder
COPY --from=prod-base --link /var/www/html/vendor/emargareten/inertia-modal  ./vendor/emargareten/inertia-modal

RUN pnpm run build

###########################################
# Production Final
###########################################
FROM prod-base AS prod

USER ${USER}

COPY --link --chown=${USER_ID}:${GROUP_ID} --from=build /app/public public

# Final cleanup and asset publishing
RUN php artisan vendor:publish --tag=log-viewer-assets --force && \
    php artisan vendor:publish --tag=api-platform-assets --force && \
    rm -f database/database.sqlite

EXPOSE 80 2019

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=1s --timeout=3s --retries=10 CMD healthcheck || exit 1
