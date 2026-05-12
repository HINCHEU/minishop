FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    curl \
    mysql-client \
    zip \
    unzip \
    git

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application
COPY . .

# Create .env file from .env.example
RUN cp .env.example .env

# Install dependencies
RUN composer install --no-interaction

# Copy nginx config
COPY nginx.conf /etc/nginx/http.d/default.conf

# Fix permissions
RUN chmod -R 755 storage bootstrap/cache

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
