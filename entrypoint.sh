#!/bin/sh
# Ejecutar migraciones
php artisan migrate --force

php artisan db:seed --force

# Iniciar Apache
apache2-foreground
