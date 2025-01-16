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
composer require predis/predis:^2.0

#sudo apt-get install lsb-release curl gpg
#curl -fsSL https://packages.redis.io/gpg | sudo gpg --dearmor -o /usr/share/keyrings/redis-archive-keyring.gpg
#sudo chmod 644 /usr/share/keyrings/redis-archive-keyring.gpg
#echo "deb [signed-by=/usr/share/keyrings/redis-archive-keyring.gpg] https://packages.redis.io/deb $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/redis.list
#sudo apt-get update
#sudo apt-get install redis -y
#sudo systemctl enable redis-server
#sudo systemctl start redis-server
# Atualizar dependências do Composer
apt install -q -y libpq-dev && \
docker-php-ext-install pdo_pgsql pgsql
service php-fpm restart
composer install && composer update