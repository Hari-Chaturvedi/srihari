FROM php:8.2-apache
WORKDIR /var/www/html
COPY . .

# Install dependencies
RUN apt-get update && \
    apt-get install -y git zip unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev

# Apache config
RUN a2enmod rewrite
CMD ["apache2-foreground"]