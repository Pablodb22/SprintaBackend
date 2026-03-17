# Imagen base de PHP con FPM
FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql bcmath zip

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece directorio de trabajo
WORKDIR /var/www

# Copia archivos del proyecto
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos de almacenamiento y cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expone el puerto que usará PHP-FPM
EXPOSE 9000

# Comando por defecto al iniciar el contenedor
CMD ["php-fpm"]