FROM php:8.2-apache

# Install pdo_mysql extension
RUN docker-php-ext-install pdo_mysql

# Expose port 80
EXPOSE 80

# Copy app source code
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html
