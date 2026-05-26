# ============================================================
# ConnectShare — Railway Production Dockerfile
# Single container: Nginx + PHP-FPM via supervisord
# ============================================================

# ── Stage 1: PHP base ──────────────────────────────────────
FROM php:8.4-fpm-alpine AS php-base

WORKDIR /var/www/html

RUN apk add --no-cache \
        bash \
        curl \
        git \
        icu-libs \
        libpq \
        libzip \
        oniguruma \
        unzip \
        nginx \
        supervisor \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        libzip-dev \
        oniguruma-dev \
        postgresql-dev \
    && docker-php-ext-install pdo_pgsql mbstring intl zip opcache bcmath \
    && apk del --no-network .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# ── Stage 2: Composer dependencies ─────────────────────────
FROM php-base AS vendor

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --no-scripts \
    --optimize-autoloader


# ── Stage 3: Frontend build ────────────────────────────────
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json .npmrc ./
RUN npm ci --no-fund --no-audit

COPY resources ./resources
COPY vite.config.js postcss.config.js tailwind.config.js ./

RUN npm run build


# ── Stage 4: Production image ──────────────────────────────
FROM php-base AS production

# Copy application code
COPY . .
COPY --from=vendor /var/www/html/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

# Copy Railway-specific configs
COPY docker/railway/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/railway/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/railway/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY docker/railway/php-fpm-pool.conf /usr/local/etc/php-fpm.d/zz-railway.conf

# PHP production optimizations
COPY docker/railway/php.ini /usr/local/etc/php/conf.d/99-railway.ini

# Permissions & directories
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && rm -f bootstrap/cache/*.php \
    && mkdir -p \
        storage/framework/{cache,sessions,testing,views} \
        storage/logs \
        storage/app/public \
        bootstrap/cache \
        /var/log/supervisor \
        /run/nginx \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Railway dynamically assigns PORT — default to 8080
ENV PORT=8080

EXPOSE ${PORT}

ENTRYPOINT ["entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
