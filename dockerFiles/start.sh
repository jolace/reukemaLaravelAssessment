set -e

echo "Running the queue..."
php /var/www/html/artisan queue:work --verbose --tries=3 --timeout=1200