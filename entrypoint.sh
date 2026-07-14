#!/bin/bash
set -e

cd /var/www/html

echo "Preparando Laravel..."

# Crear directorios necesarios
mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Permisos
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Optimizar cachés para producción (y exponer variables de entorno a Apache)
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
echo "Esperando conexión con la base de datos..."

MAX_RETRIES=30
COUNT=0

until php artisan migrate:status >/dev/null 2>&1; do
    COUNT=$((COUNT+1))

    if [ "$COUNT" -ge "$MAX_RETRIES" ]; then
        echo "ERROR: No fue posible conectar con la base de datos."
        exit 1
    fi

    echo "Base de datos no disponible... reintentando ($COUNT/$MAX_RETRIES)"
    sleep 5
done

echo "Base de datos disponible."

# Ejecutar migraciones
php artisan migrate --force

# Ejecutar seeders solo si está habilitado
if [ "${RUN_SEEDERS:-false}" = "true" ]; then
    echo "Ejecutando seeders..."
    php artisan db:seed --force
fi

# Crear enlace storage
if [ ! -L public/storage ]; then
    php artisan storage:link || true
fi

echo "Iniciando Apache..."

exec apache2-foreground