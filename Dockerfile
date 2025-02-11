# Use an official PHP-Apache image from Docker Hub
FROM php:8.0-apache

# Install additional dependencies (optional)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev git unzip

# Enable Apache mod_rewrite for clean URLs
RUN a2enmod rewrite

# Copy your PHP project files into the Apache server directory
COPY . /var/www/html/

# Set file permissions to allow Apache to access them
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 (default for Apache)
EXPOSE 80

# Start the Apache web server
CMD ["apache2-foreground"]
