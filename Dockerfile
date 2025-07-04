# Use a base PHP image with Apache (Heroku's recommended base)
FROM heroku/heroku:22-build-php-8.2

# Set working directory
WORKDIR /app

# Copy composer.json and composer.lock first to leverage Docker cache
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application code
COPY . .

# Expose port 80 (default for web servers)
EXPOSE 80

# Configure Apache to serve from Laravel's public directory
CMD ["vendor/bin/heroku-php-apache2", "public/"]