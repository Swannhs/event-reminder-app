FROM php:8.3-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    cron \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 777 storage bootstrap/cache

# Add cron job for Laravel Scheduler
RUN echo "* * * * * cd /app && php artisan schedule:run >> /var/log/laravel-cron.log 2>&1" | crontab -

# Start cron in the background & process Laravel queues
CMD service cron start && php artisan queue:work &
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

EXPOSE 8000
