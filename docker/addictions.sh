#!/bin/bash

# Atualizar o sistema e instalar dependências
apt-get update && apt-get install -y \
    curl \
    gnupg2 \
    lsb-release \
    software-properties-common \
    git \

# Limpar pacotes não necessários
apt-get clean
rm -rf /var/lib/apt/lists/*

# Instalar Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs
npm install
npm run build
# Baixar e instalar o Composer
curl -sS https://getcomposer.org/installer -o composer-setup.php
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php

# Atualizar dependências do Composer
composer install && composer update
