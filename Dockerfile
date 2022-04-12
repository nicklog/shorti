ARG PHP_EXTENSIONS="pdo_mysql"

FROM thecodingmachine/php:8.1-v4-apache-node16 as builder

COPY --chown=docker:docker . /var/www/html/

RUN composer install --no-dev --no-interaction --no-progress --classmap-authoritative && \
    yarn install --force && \
    yarn prod && \
    sudo rm -rf assets docker docs node_modules tests \
    .env.test .gitignore composer-require-checker.json composer-unused.php rector.php tsconfig.json docker-compose.yml Makefile package.json \
    phpcs.xml phpstan.neon phpstan-baseline.neon phpunit.xml webpack.config.js yarn.lock composer.lock symfony.lock
    
FROM thecodingmachine/php:8.1-v4-slim-apache

COPY --from=builder /var/www/html /var/www/html

ENV TEMPLATE_PHP_INI="production"
    
ENV STARTUP_COMMAND_1="bin/console cache:clear" \
    STARTUP_COMMAND_2="bin/console cache:warmup"  \
    STARTUP_COMMAND_3="bin/console doctrine:migrations:migrate --no-interaction" 

ENV APACHE_DOCUMENT_ROOT="public/" \
    APACHE_RUN_USER=www-data \
    APACHE_RUN_GROUP=www-data

VOLUME /var/www/html/
EXPOSE 80
