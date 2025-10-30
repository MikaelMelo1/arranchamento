# Base PHP + Apache
FROM php:8.2-apache

# Instalar extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql \
 && a2enmod rewrite headers expires

# Timezone (opcional)
ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Configurar DocumentRoot (opcional, padrão /var/www/html)
WORKDIR /var/www/html

# Copiar o código (em dev usaremos bind mount; copiar garante imagem funcional)
COPY . /var/www/html

# Ajustar permissões básicas
RUN chown -R www-data:www-data /var/www/html

# Expor porta padrão do Apache
EXPOSE 80

# Comando padrão
CMD ["apache2-foreground"]

