FROM dunglas/frankenphp

RUN install-php-extensions \
    pdo_pgsql \
    pgsql \
    pcntl

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
