#!/bin/bash
set -e

echo "Iniciando despliegue de Laravel en Render..."

# Optimizar cachés
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones si es necesario
echo "Ejecutando migraciones..."
php artisan migrate --force

# Ceder control al proceso principal de apache (pasado por CMD)
exec "$@"
