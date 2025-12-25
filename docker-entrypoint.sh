#!/bin/bash
set -e

# ตรวจสอบว่ามี vendor folder และมี autoload.php หรือยัง
if [ ! -f "/var/www/html/vendor/autoload.php" ]; then
    echo "📦 Installing Composer dependencies..."
    cd /var/www/html
    composer install --no-interaction --optimize-autoloader
    echo "✅ Composer install completed!"
else
    echo "✅ Vendor folder already exists, skipping composer install."
fi

# รัน Apache ใน foreground
echo "🚀 Starting Apache..."
exec apache2-foreground
