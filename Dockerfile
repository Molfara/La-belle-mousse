FROM php:8.2-apache

# Installation des dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && docker-php-ext-install zip pdo pdo_mysql mbstring exif pcntl bcmath gd

# Configuration de Git pour considérer le répertoire de travail comme sécurisé
RUN git config --global --add safe.directory /var/www/html

# Installation du pilote MongoDB pour PHP avec une version spécifique
RUN pecl install mongodb-1.20.0 && docker-php-ext-enable mongodb

# Activation du module rewrite d'Apache pour les URL propres
RUN a2enmod rewrite

# Définition du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers du projet dans le conteneur
COPY . /var/www/html/

# Installation de Composer pour la gestion des dépendances PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installation des dépendances du projet via Composer
# Avec option d'ignorer les exigences de plateforme pour MongoDB
# Si l'installation échoue, tente une mise à jour des dépendances
RUN composer install --no-interaction --no-dev --optimize-autoloader --ignore-platform-req=ext-mongodb || composer update --no-interaction --no-dev

# Attribution des droits d'accès appropriés pour l'utilisateur du serveur web
RUN chown -R www-data:www-data /var/www/html
