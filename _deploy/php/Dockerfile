FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip curl cron supervisor \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev libmcrypt-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# Install Composer & Laravel
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer global require laravel/installer

# Add cron job (example)
COPY supervisord.conf /etc/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
