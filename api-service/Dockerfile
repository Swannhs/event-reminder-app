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

RUN echo "* * * * * cd /app && php artisan schedule:run >> /dev/null 2>&1" | crontab -

EXPOSE 8000

CMD cron && php artisan serve --host=0.0.0.0 --port=8000
