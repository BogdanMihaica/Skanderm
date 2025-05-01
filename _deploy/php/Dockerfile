# source: https://github.com/laradock/laradock/blob/master/php-fpm/Dockerfile, https://github.com/laradock/php-fpm/blob/master/Dockerfile-8.2

ARG PHP_VERSION="8.2"

#--------
# STEP 1 - START (source: https://github.com/laradock/php-fpm/blob/master/Dockerfile-8.2)
#--------

FROM php:8.2-fpm

# Set Environment Variables
ENV DEBIAN_FRONTEND noninteractive

#
#--------------------------------------------------------------------------
# Software's Installation
#--------------------------------------------------------------------------
#
# Installing tools and PHP extentions using "apt", "docker-php", "pecl",
#

# Install "curl", "libmemcached-dev", "libpq-dev", "libjpeg-dev",
#         "libpng-dev", "libfreetype6-dev", "libssl-dev", "libmcrypt-dev",
RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
            curl \
            libmemcached-dev \
            libz-dev \
            libpq-dev \
            libjpeg-dev \
            libpng-dev \
            libfreetype6-dev \
            libssl-dev \
            libwebp-dev \
            libxpm-dev \
            libmcrypt-dev \
            libonig-dev; \
    rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    # Install the PHP pdo_mysql extention
    docker-php-ext-install pdo_mysql; \
    # Install the PHP pdo_pgsql extention
    docker-php-ext-install pdo_pgsql; \
    # Install the PHP gd library
    docker-php-ext-configure gd \
            --prefix=/usr \
            --with-jpeg \
            --with-webp \
            --with-xpm \
            --with-freetype; \
    docker-php-ext-install gd; \
    php -r 'var_dump(gd_info());'

#--------
# STEP 2 - START (source: https://github.com/laradock/laradock/blob/master/php-fpm/Dockerfile)
#--------

# always run apt update when start and after add new source list, then clean up at end.
RUN set -xe; \
    apt-get update -yqq && \
    pecl channel-update pecl.php.net && \
    apt-get install -yqq \
    apt-utils \
    gnupg2 \
    git \
    #
    #--------------------------------------------------------------------------
    # Mandatory Software's Installation
    #--------------------------------------------------------------------------
    #
    # Mandatory Software's such as ("mcrypt", "pdo_mysql", "libssl-dev", ....)
    # are installed on the base image 'laradock/php-fpm' image. If you want
    # to add more Software's or remove existing one, you need to edit the
    # base image (https://github.com/Laradock/php-fpm).
    #
    # next lines are here becase there is no auto build on dockerhub see https://github.com/laradock/laradock/pull/1903#issuecomment-463142846
    libzip-dev zip unzip && \
    if [ ${PHP_VERSION} = "7.3" ] || [ ${PHP_VERSION} = "7.4" ] || [ $(php -r "echo PHP_MAJOR_VERSION;") = "8" ]; then \
        docker-php-ext-configure zip; \
    else \
        docker-php-ext-configure zip --with-libzip; \
    fi && \
    # Install the zip extension
    docker-php-ext-install zip && \
    php -m | grep -q 'zip'

#--------
# STEP 3 - START (extra custom things)
#--------

# cron, vim, supervisor
RUN apt-get install -yqq \
    cron \
    vim \
    supervisor

RUN set -xe; \
    docker-php-ext-install mbstring exif pcntl bcmath gd opcache

# Get latest Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

USER root

# PHP Redis Extension
RUN pecl install -o -f redis; \
    rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# IMAP
RUN apt-get install -yqq libc-client-dev libkrb5-dev && \
    docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
    docker-php-ext-install imap

# Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Configure non-root user to use the user & group ids from the docker arguments
ARG UID=1000
ENV UID ${UID}
ARG GID=1000
ENV GID ${GID}

RUN groupmod -o -g ${GID} www-data && \
    usermod -o -u ${UID} -g www-data www-data && \
    # create home folder for www-data user
    mkdir -p /home/www-data && \
    chown -R www-data:www-data /home/www-data && \
    usermod -d /home/www-data www-data

# Configure locale
ARG LOCALE=POSIX
ENV LC_ALL ${LOCALE}

# copy configs (don't need them as volume because they don't change)
COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini

# Cronjob (this will be used by the cron container)
ARG CONTAINER_ROLE
RUN if [ ${CONTAINER_ROLE} = 'cron' ]; then \
    echo "* * * * * www-data cd /var/www && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontab; \
fi

WORKDIR /var/www

# USER ${PNAME}