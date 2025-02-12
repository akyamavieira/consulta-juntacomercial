# Estágio de build para Node.js
FROM node:20 AS node_build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Estágio de build para Composer
FROM php:8.3-cli AS composer_build
WORKDIR /app

# Instalar dependências do sistema e extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/*

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar todos os arquivos do projeto (incluindo app/Helpers)
COPY . .

# Instalar dependências do Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs

# Estágio final
FROM php:8.3-apache
WORKDIR /var/www/html
ENV SCRIPT_NAME=script.sh


# Copiar apenas os arquivos necessários
COPY --from=node_build /app/public /var/www/html/public
COPY --from=composer_build /app/vendor /var/www/html/vendor
COPY --from=composer_build /app/bootstrap /var/www/html/bootstrap
COPY --from=composer_build /app/config /var/www/html/config
COPY --from=composer_build /app/database /var/www/html/database
COPY --from=composer_build /app/resources /var/www/html/resources
COPY --from=composer_build /app/routes /var/www/html/routes
COPY --from=composer_build /app/storage /var/www/html/storage
COPY --from=composer_build /app/tests /var/www/html/tests
COPY --from=composer_build /app/app /var/www/html/app
COPY --from=composer_build /app/composer.json /var/www/html/composer.json
COPY docker/script.sh /usr/local/bin/
COPY docker/script-ssl.sh /usr/local/bin
COPY .env* /var/www/html/

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && chmod +x /usr/local/bin/*.sh

# Definir o ServerName para suprimir o aviso
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expor as portas padrão do Apache
EXPOSE 80 443

# Comando final para rodar o Apache
ENTRYPOINT ["/bin/bash", "-c", "/usr/local/bin/${SCRIPT_NAME} && apache2-foreground"]