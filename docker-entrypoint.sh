#!/bin/sh
# Prepara el entorno de Laravel en cada arranque y delega al CMD (Apache).
set -e
cd /var/www/html

# .env desde el ejemplo si no existe (Coolify puede inyectar APP_URL/APP_ENV/etc.)
[ -f .env ] || cp .env.example .env

# APP_KEY si falta (Laravel no arranca sin clave)
if ! grep -q "^APP_KEY=base64:" .env 2>/dev/null; then
  php artisan key:generate --force
fi

# Base SQLite (DB_CONNECTION=sqlite; sesiones y caché viven en la base)
touch database/database.sqlite
chown www-data:www-data database/database.sqlite

# Demo siempre pristino: recrea el esquema y resiembra en cada arranque.
php artisan migrate:fresh --seed --force

# Symlink de storage por si alguna imagen se sirve desde storage/app/public.
php artisan storage:link 2>/dev/null || true

# Cache de producción (toma las envs ya presentes, incl. las de Coolify).
php artisan config:cache
php artisan route:cache
php artisan view:cache

chown -R www-data:www-data storage bootstrap/cache database

exec "$@"
