FROM php:8.2-apache

# Install system dependencies + MySQLi
RUN apt-get update && \
    apt-get install -y \
    git \
    zip \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
WORKDIR /var/www/html
COPY . .

# Install PHP dependencies (ignore platform reqs temporarily)
RUN composer install --no-dev --ignore-platform-reqs

# Apache config
RUN a2enmod rewrite
EXPOSE 80
CMD ["apache2-foreground"]
