ARG PHP_EXTENSIONS="pdo_mysql"

FROM thecodingmachine/php:8.0-v4-apache-node14 as builder

COPY --chown=docker:docker . /var/www/html/

RUN composer install --no-dev --no-interaction --no-progress --classmap-authoritative && \
    yarn install --force && \
    yarn prod && \
    sudo rm -rf assets docker docs node_modules tests \ 
    .env.test .gitignore composer-require-checker.json docker-compose.yml Makefile package.json \
    phpcs.xml phpstan.neon phpstan-baseline.neon phpunit.xml webpack.config.js yarn.lock
    
FROM thecodingmachine/php:8.0-v4-slim-apache

ENV TEMPLATE_PHP_INI="production"
    
ENV STARTUP_COMMAND_1="bin/console cache:clear" \
    STARTUP_COMMAND_2="bin/console cache:warmup"  \
    STARTUP_COMMAND_3="bin/console doctrine:migrations:migrate --no-interaction" 

ENV APACHE_DOCUMENT_ROOT="public/"

RUN touch /home/docker/.bashrc && printf '\
HISTFILE=~/bash_history\n\
PROMPT_COMMAND="history -a;history -n"\n\
umask 027\n' >> /home/docker/.bashrc

VOLUME /var/www/html/
EXPOSE 80
