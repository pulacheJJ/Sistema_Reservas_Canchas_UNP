#!/bin/sh
# Ejecutar migraciones
php artisan migrate --force

# Iniciar Apache
apache2-foreground