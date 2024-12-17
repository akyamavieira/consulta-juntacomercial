# Usar a imagem oficial do PHP com Apache
FROM php:8.3-apache

ENV SCRIPT_NAME=script.sh

WORKDIR /var/www/html

COPY . .

# Copiar o script de instalação de dependências para o contêiner
COPY docker/addictions.sh /usr/local/bin/addicitons.sh

# Copiar o arquivo de configuração do apacha (script.sh ou script-ssl.sh)
COPY docker/script.sh docker/script-ssl.sh  /usr/local/bin/

# Dar permissões de execução aos scripts
RUN chmod +x /usr/local/bin/*.sh

# Executar o script para instalar dependências e configurar o ambiente
RUN /usr/local/bin/addicitons.sh

# Definir permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Definir o ServerName para suprimir o aviso
RUN echo "ServerName 10.23.4.210" >> /etc/apache2/apache2.conf

# Expor as portas padrão do Apache
EXPOSE 80 443

# Comando final para rodar o Apache
ENTRYPOINT ["/bin/bash", "-c", "/usr/local/bin/${SCRIPT_NAME} && apache2-foreground"]