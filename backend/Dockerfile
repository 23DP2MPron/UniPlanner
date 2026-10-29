FROM node:22-alpine AS assets
WORKDIR /app/frontend
COPY frontend/package*.json frontend/.npmrc ./
RUN npm ci
COPY frontend/ ./
COPY backend/resources/views/ /app/backend/resources/views/
RUN npm run build

FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    zip \
    unzip \
    default-mysql-client \
    nginx \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY backend/ /var/www/html
COPY backend/.env.docker /var/www/html/.env

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Include the compiled frontend and Laravel's asset manifest.
COPY --from=assets /app/frontend/dist /var/www/html/public/build

# Copy nginx configuration
COPY backend/docker/nginx/default.conf /etc/nginx/sites-available/default

# Copy supervisor configuration
COPY backend/docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
