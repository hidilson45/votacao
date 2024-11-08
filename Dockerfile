# Base image com PHP e Apache
FROM php:8.1-apache

# Instala extensões PHP necessárias para conexão com o MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copia o código do projeto para o diretório padrão do Apache
COPY public/ /var/www/html

# Configura permissões (caso seja necessário)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponha a porta 80 para acesso ao servidor
EXPOSE 80
