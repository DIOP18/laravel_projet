FROM php:8.2-fpm

# Arguments définis dans docker-compose.yml
ARG user
ARG uid

# Installer les dépendances
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Nettoyer le cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer un utilisateur système pour exécuter Composer et Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers du projet
COPY . /var/www/

# Copier les autorisations correctes
COPY --chown=$user:$user . /var/www/

# Installer les dépendances
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Changer le propriétaire du répertoire storage
RUN chown -R $user:$user \
    /var/www/storage \
    /var/www/bootstrap/cache

# Basculer vers l'utilisateur non root
USER $user

# Exposer le port 9000
EXPOSE 9000

CMD ["php-fpm"]
