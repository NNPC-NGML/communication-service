FROM php:8.2-cli

RUN apt-get update && \
    apt-get install -y zip unzip p7zip-full && \
    docker-php-ext-install pdo pdo_mysql sockets && \
    rm -rf /var/lib/apt/lists/*

# RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
RUN composer install
