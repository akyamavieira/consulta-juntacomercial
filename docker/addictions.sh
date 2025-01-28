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

apt install -q -y libpq-dev && \
docker-php-ext-install pdo_pgsql pgsql

composer install && composer update