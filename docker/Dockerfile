FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    librabbitmq-dev \
    pkg-config \
    autoconf \
    g++ \
    make \
    && docker-php-ext-install pdo pdo_pgsql \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app

RUN composer install

CMD ["php", "-S", "0.0.0.0:8001", "-t", "public"]