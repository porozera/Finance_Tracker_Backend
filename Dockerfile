# Gunakan image resmi PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi PHP yang diperlukan
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy proyek Laravel ke dalam container
COPY . /var/www/html

# Set direktori kerja
WORKDIR /var/www/html

# Set permission untuk Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Expose port 80
EXPOSE 80

# Command default untuk Apache
CMD ["apache2-foreground"]
