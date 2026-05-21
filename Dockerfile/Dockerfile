FROM dunglas/frankenphp

RUN install-php-extensions \
pdo_pgsql \
mongodb

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["php-server"]