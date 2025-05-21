#!/bin/sh
set -e

echo "🔧 Adjusting permissions for Symfony..."

echo "🔹 Ensuring log directories exist..."
mkdir -p /var/www/html/var/log

if [ "$(id -u)" = "0" ]; then
    echo "🔹 Setting ownership for cache and logs..."
    chown -R www-data:www-data /var/www/html/var /var/www/html/config || true
    chmod -R 775 /var/www/html/var /var/www/html/config
fi

echo "⚙️ Running Doctrine migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "🔍 Current directory permissions:"
ls -la /var/www/html/var
ls -la /var/www/html/public
ls -la /var/www/html/config

echo "🚀 Starting Apache..."
exec apache2-foreground
