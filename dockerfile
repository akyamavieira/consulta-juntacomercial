# Usar a imagem oficial do PHP com Apache
FROM php:8.3-apache

WORKDIR /var/www/html

COPY . .

# Copiar o script de instalação de dependências para o contêiner
COPY docker/addictions.sh /usr/local/bin/addictions.sh

# Copiar o arquivo de configuração do apacha (script.sh ou script-ssl.sh)
COPY docker/script.sh /usr/local/bin/

# Dar permissões de execução aos scripts
RUN chmod +x /usr/local/bin/*.sh

# Atualizar o sistema e instalar as dependências diretamente no Dockerfile
RUN apt-get update && apt-get install -y \
    curl \
    gnupg2 \
    lsb-release \
    software-properties-common \
    git \
    zip \
    unzip \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Limpar pacotes não necessários
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Executar o script para instalar dependências e configurar o ambiente
RUN /usr/local/bin/addictions.sh

# Definir permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Expor as portas padrão do Apache
EXPOSE 80

# Comando final para rodar o Apache
ENTRYPOINT ["/bin/bash", "-c", "/usr/local/bin/script.sh && apache2-foreground"]