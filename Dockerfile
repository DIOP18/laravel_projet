FROM php:8.2-fpm

# Installer les dépendances
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Installer les extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier d'abord composer.json et composer.lock
COPY composer.json composer.lock ./

# Installer les dépendances
RUN composer install --no-scripts --no-autoloader --no-dev

# Copier le reste des fichiers du projet (sauf ceux dans .dockerignore)
COPY . .

# Générer l'autoloader optimisé
RUN composer dump-autoload --optimize

# S'assurer que le symlink problématique n'existe pas
RUN rm -rf public/storage || true

# Créer les dossiers nécessaires pour storage
RUN mkdir -p storage/app/public \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Créer un nouveau symlink propre à l'intérieur du conteneur
RUN ln -s ../storage/app/public public/storage

# Définir les permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
