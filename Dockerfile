# Gunakan image PHP dengan Apache
FROM php:8.2-apache

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy semua file Laravel ke container
COPY . /var/www/html

# Set Apache DocumentRoot ke folder public Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/apache2.conf

# Aktifkan mod_rewrite untuk Laravel
RUN a2enmod rewrite

# Set permission yang benar untuk Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependensi Laravel
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Expose port 80
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
