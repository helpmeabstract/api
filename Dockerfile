FROM php:7.1.8-apache

RUN apt-get update && apt-get install -y zlib1g-dev git && apt-get clean && apt-get autoremove

RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

WORKDIR /var/www

ONBUILD COPY src html composer.json /var/www/
ONBUILD COPY ./scripts/install_composer.php /tmp
ONBUILD RUN php /tmp/install_composer.php && composer install && composer dump-autoload -o
