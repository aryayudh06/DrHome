FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  nodejs \
  npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory
COPY . .

# Create .env file from environment variables
RUN echo "APP_ENV=production\n\
  APP_DEBUG=false\n\
  APP_KEY=${APP_KEY}\n\
  APP_URL=${APP_URL}\n\
  LOG_CHANNEL=stderr\n\
  LOG_LEVEL=debug\n\
  DB_CONNECTION=mysql\n\
  DB_HOST=${MYSQL_HOST}\n\
  DB_PORT=${MYSQL_PORT}\n\
  DB_DATABASE=${MYSQL_DATABASE}\n\
  DB_USERNAME=${MYSQL_USERNAME}\n\
  DB_PASSWORD=${MYSQL_PASSWORD}\n\
  BROADCAST_DRIVER=log\n\
  CACHE_DRIVER=file\n\
  FILESYSTEM_DISK=local\n\
  QUEUE_CONNECTION=sync\n\
  SESSION_DRIVER=file\n\
  SESSION_LIFETIME=120" > .env

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Apache
RUN a2enmod rewrite
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Run migrations
RUN php artisan migrate --force

# Create storage link
RUN php artisan storage:link

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
