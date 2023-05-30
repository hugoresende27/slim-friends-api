# Use an official PHP runtime as the base image
FROM php:8.0-apache

# Set the working directory in the container
WORKDIR /var/www/html/

# Copy the project files to the container
COPY . /var/www/html/


# Install dependencies using Composer
RUN apt-get update && \
    apt-get install -y zip && \
    apt-get install -y unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader

# Enable Apache rewrite module
RUN a2enmod rewrite

# Expose the container's port
EXPOSE 66

# Start the Apache server
CMD ["apache2-foreground"]
