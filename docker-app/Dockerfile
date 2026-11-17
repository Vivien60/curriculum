FROM php:8.5-apache AS apache-php

# PHP
COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd zip

# ne pas lister le contenu des dossiers
RUN sed -ri '/<Directory \/var\/www\/>/,/<\/Directory>/ s/Options Indexes FollowSymLinks/Options FollowSymLinks/' /etc/apache2/apache2.conf

EXPOSE 80
EXPOSE 443

# étape dev : part de l'étape 1
FROM apache-php AS dev

# étape prod : part de l'étape 1
FROM apache-php AS prod
# php.ini de production : pas d'erreurs affichées, expose_php désactivé
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./ /var/www/html/
# Code en lecture seule pour Apache (www-data) : propriétaire root, pas d'écriture
# pour les autres. Retire aussi le 1777 (sticky + écriture pour tous) posé par l'image de base.
RUN chown -R root:root /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} + \
    && find /var/www/html -type f -exec chmod 644 {} +
