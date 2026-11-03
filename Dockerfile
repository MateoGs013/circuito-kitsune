# syntax=docker/dockerfile:1

# --- assets: compila los assets de Vite (Tailwind v4 + Alpine) ---
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

# --- app: PHP 8.3 + Apache sirviendo Laravel ---
FROM php:8.3-apache

# Extensiones: pdo_sqlite (la base es SQLite) y zip (composer)
RUN apt-get update && apt-get install -y --no-install-recommends \
      libsqlite3-dev libzip-dev unzip \
    && docker-php-ext-install pdo_sqlite zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# DocumentRoot -> public/ y mod_rewrite (rutas de Laravel)
RUN a2enmod rewrite \
    && sed -ri 's!/var/www/html!/var/www/html/public!g' \
         /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html

# Código de la app + dependencias PHP de producción
COPY . .
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Assets compilados desde la etapa de Node
COPY --from=assets /app/public/build ./public/build

RUN chmod +x docker-entrypoint.sh \
    && chown -R www-data:www-data storage bootstrap/cache database

EXPOSE 80
ENTRYPOINT ["./docker-entrypoint.sh"]
CMD ["apache2-foreground"]
