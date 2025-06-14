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

# Skip setting .env here; set it using Railway variables

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Apache
RUN a2enmod rewrite
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
