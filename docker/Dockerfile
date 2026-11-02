FROM php:8.5-apache AS apache-php

# PHP
RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y zlib1g-dev libwebp-dev libpng-dev && docker-php-ext-install gd
RUN apt-get install libzip-dev -y && docker-php-ext-install zip

# Apache
RUN a2enmod rewrite

EXPOSE 80
EXPOSE 8080
EXPOSE 443

# étape dev : part de l'étape 1
FROM apache-php AS dev

# étape prod : part de l'étape 1
FROM apache-php AS prod
COPY ./app /var/www/html/
