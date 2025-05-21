# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Set environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    APACHE_DOCUMENT_ROOT=/var/www/html/public

# Set build argument for APP_ENV
ARG APP_ENV=dev
ENV APP_ENV=${APP_ENV}

# Install system dependencies
# Install required PHP extensions including amqp
RUN apt-get update && apt-get install -y \
    librabbitmq-dev \
    libssh-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libicu-dev \
    libzip-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        pdo \
        intl \
        zip \
        gd \
        opcache \
        xml \
        simplexml \
        dom \
        curl \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install required PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
    pdo_mysql \
    pdo \
    intl \
    zip \
    gd \
    opcache \
    xml \
    simplexml \
    dom \
    curl

# Enable installed extensions
RUN docker-php-ext-enable opcache gd intl xml curl

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Copy application files
COPY . .

# Ensure correct permissions on first start
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Ensure the public directory is set as DocumentRoot
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf
# **💡 Instalar Monolog antes de ejecutar `composer install`**
RUN composer require symfony/monolog-bundle --no-scripts --no-progress --no-interaction || true
# Install Symfony dependencies
RUN if [ "$APP_ENV" = "prod" ]; then \
        composer install --no-interaction --no-dev --optimize-autoloader; \
    else \
        composer install --no-interaction --optimize-autoloader; \
    fi

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/public /var/www/html/config
RUN chmod -R 775 /var/www/html/var /var/www/html/public /var/www/html/config

# Set entrypoint
ENTRYPOINT ["/entrypoint.sh"]

# Start Apache
CMD ["apache2-foreground"]

# Expose port 80
EXPOSE 80
