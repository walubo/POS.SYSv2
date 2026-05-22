#!/usr/bin/env bash

# Set up local paths for PHP and Node
export PATH="/home/ariesu_linux/local-node/bin:/home/ariesu_linux/local-php:$PATH"
export PHP_BINARY="/home/ariesu_linux/local-php/php"

echo "=== System Environment ==="
echo "PHP Binary:  $(which php)"
echo "Node Binary: $(which node)"
echo "=========================="

# Clear Laravel cache to ensure fresh config
php artisan optimize:clear

# Start development servers concurrently
exec npx concurrently \
  -c "#93c5fd,#c4b5fd,#fb7185" \
  "(cd public && exec /home/ariesu_linux/local-php/php -S 127.0.0.1:8000 ../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php)" \
  "php artisan queue:listen --tries=1 --timeout=0" \
  "npm run dev" \
  --names="server,queue,vite" \
  --kill-others

