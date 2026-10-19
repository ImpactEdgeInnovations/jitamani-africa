FROM php:8.4-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git unzip libicu-dev libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd intl mbstring zip exif \
    && a2dismod mpm_event mpm_worker \
    && a2enmod mpm_prefork rewrite headers \
    && printf '<Directory /var/www/html>\nAllowOverride All\nOptions -Indexes\nRequire all granted\n</Directory>\n' > /etc/apache2/conf-available/jitamani.conf \
    && a2enconf jitamani \
    && apache2ctl -t \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www/html
COPY . .
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader \
    && mkdir -p media site/accounts site/cache site/sessions site/logs \
    && chown -R www-data:www-data media site/accounts site/cache site/sessions site/logs

# This image is for design review. cPanel deployment does not use Docker.
ENV JA_DEMO=1
EXPOSE 80
CMD ["apache2-foreground"]
