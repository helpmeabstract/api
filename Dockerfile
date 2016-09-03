FROM php:7-apache
RUN apt-get update && apt-get install -y zlib1g-dev git && apt-get clean && apt-get autoremove
RUN docker-php-ext-install zip

COPY /scripts/install_composer.php /tmp
RUN php /tmp/install_composer.php

RUN chown -R www-data:www-data /var/www
WORKDIR /var/www
COPY composer.json ./composer.json
COPY src ./src/
COPY html ./html/
RUN composer install --no-dev --no-interaction --no-ansi --no-plugins --no-scripts

