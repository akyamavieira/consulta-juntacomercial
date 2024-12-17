#!/bin/bash

# Atualizar o sistema e instalar dependências
apt-get update && apt-get install -y \
    curl \
    gnupg2 \
    lsb-release \
    software-properties-common \
    unixodbc-dev \
    git \
    libzip-dev \
    libldap2-dev

# Instalar extensões PHP
docker-php-ext-install ldap zip

# Configurar o repositório Microsoft para msodbcsql17
echo "deb [arch=amd64] https://packages.microsoft.com/debian/12/prod/ $(lsb_release -cs) main" > /etc/apt/sources.list.d/microsoft-prod.list
curl -sSL https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
apt-get update
ACCEPT_EULA=Y apt-get install -y msodbcsql17

# Instalar a extensão pdo_sqlsrv via PECL
pecl install pdo_sqlsrv
docker-php-ext-enable pdo_sqlsrv

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
composer update && composer install

# Instalar o OpenSSL e copiar o arquivo de configuração
apt-get update -yqq
apt-get install -y --no-install-recommends openssl
rm -rf /var/lib/apt/lists/*
cp /var/www/html/docker/openssl.cnf /etc/ssl/openssl.cnf
