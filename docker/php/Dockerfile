FROM php:8.3-fpm

# Přidáme vlastního uživatele
RUN useradd -u 1000 appuser

# Instalace systémových knihoven a PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Instalace Composeru
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Přepneme na appusera
USER appuser

WORKDIR /app
