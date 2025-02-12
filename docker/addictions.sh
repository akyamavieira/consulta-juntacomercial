#!/bin/bash

# Instalar Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs
npm install
npm run build

# Baixar e instalar o Composer
curl -sS https://getcomposer.org/installer -o composer-setup.php
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php

# Instalar extensões do PostgreSQL
apt install -q -y libpq-dev
docker-php-ext-install pdo_pgsql pgsql

#Instalar Dependências e extensions php
apt-get update && apt-get install -y \
    curl \
    gnupg2 \
    lsb-release \
    software-properties-common \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

#Limpar pacotes
apt-get clean && rm -rf /var/lib/apt/lists/*

#Dando permissão para a pasta padrão do apache
chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Instalar dependências do Composer
composer install --no-interaction --optimize-autoloader --no-dev