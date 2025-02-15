#!/bin/bash

# Start cron service
service cron start

echo "📌 Waiting for database to be ready..."

# Maximum retries before failing
MAX_RETRIES=30
RETRY_DELAY=5
COUNTER=0

# Check database connection using PDO instead of artisan command
until php -r "
try {
    new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    exit(0);
} catch (PDOException \$e) {
    exit(1);
}
" > /dev/null 2>&1; do
    echo "❌ Database not ready. Retrying in ${RETRY_DELAY} seconds... (Attempt: $((COUNTER+1))/${MAX_RETRIES})"
    sleep ${RETRY_DELAY}

    COUNTER=$((COUNTER+1))
    if [ ${COUNTER} -ge ${MAX_RETRIES} ]; then
        echo "🚨 Database connection timeout! Exiting..."
        exit 1
    fi
done

echo "✅ Database is ready!"

# Generate swagger documentation
echo "🚀 Generating Swagger documentation..."
php artisan l5-swagger:generate

# Run migrations & seed the database
echo "🚀 Running migrations..."
php artisan migrate:fresh --seed

# Start Laravel queue worker
echo "🚀 Starting queue worker..."
php artisan queue:work --daemon &

# Start Laravel Scheduler in the background
echo "🚀 Starting Laravel scheduler..."
php artisan schedule:work &

# Start Laravel Application
echo "🚀 Starting Laravel App..."
exec php artisan serve --host=0.0.0.0 --port=8000
