FROM php:8.5-apache AS apache-php

# PHP
COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd zip

# Apache
RUN a2enmod rewrite
# ne pas annoncer la version d'Apache, ni lister le contenu des dossiers
RUN sed -ri 's/^ServerTokens .*/ServerTokens Prod/; s/^ServerSignature .*/ServerSignature Off/' /etc/apache2/conf-available/security.conf \
 && sed -ri '/<Directory \/var\/www\/>/,/<\/Directory>/ s/Options Indexes FollowSymLinks/Options FollowSymLinks/' /etc/apache2/apache2.conf

EXPOSE 80
EXPOSE 8080
EXPOSE 443

# étape dev : part de l'étape 1
FROM apache-php AS dev

# étape prod : part de l'étape 1
FROM apache-php AS prod
# php.ini de production : pas d'erreurs affichées, expose_php désactivé
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./ /var/www/html/
