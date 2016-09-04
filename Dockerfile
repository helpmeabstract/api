FROM php:7-apache

RUN apt-get update && apt-get install -y zlib1g-dev git && apt-get clean && apt-get autoremove

RUN docker-php-ext-install zip
RUN a2enmod rewrite

WORKDIR /var/www

ONBUILD COPY src html compoer.json /var/www
ONBUILD COPY /scripts/install_composer
ONBUILD RUN php /tmp/install_composer.php && composer install && composer dump-autoload -o
